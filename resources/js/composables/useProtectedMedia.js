export function preventMediaContextMenu(event) {
    event.preventDefault();
}

export function preventMediaDrag(event) {
    event.preventDefault();
}

export function lockElementPlaybackRate(element) {
    if (!element) {
        return;
    }

    if (element.playbackRate !== 1) {
        element.playbackRate = 1;
    }

    if (element.defaultPlaybackRate !== 1) {
        element.defaultPlaybackRate = 1;
    }
}

function isMediaSpeedShortcut(event) {
    if (event.key === "<" || event.key === ">") {
        return true;
    }

    if (event.shiftKey && (event.key === "," || event.key === ".")) {
        return true;
    }

    return false;
}

export function preventMediaSpeedShortcut(event) {
    if (!isMediaSpeedShortcut(event)) {
        return;
    }

    event.preventDefault();
    event.stopPropagation();
}

export function attachNativeMediaProtection(element) {
    if (!element) {
        return () => {};
    }

    lockElementPlaybackRate(element);

    const onRateChange = () => lockElementPlaybackRate(element);
    const rateEvents = ["ratechange", "loadedmetadata", "play", "playing", "seeked", "timeupdate"];

    rateEvents.forEach((eventName) => {
        element.addEventListener(eventName, onRateChange);
    });

    element.addEventListener("contextmenu", preventMediaContextMenu);
    element.addEventListener("dragstart", preventMediaDrag);
    element.addEventListener("keydown", preventMediaSpeedShortcut, true);

    const intervalId = window.setInterval(() => {
        lockElementPlaybackRate(element);
    }, 500);

    return () => {
        rateEvents.forEach((eventName) => {
            element.removeEventListener(eventName, onRateChange);
        });
        element.removeEventListener("contextmenu", preventMediaContextMenu);
        element.removeEventListener("dragstart", preventMediaDrag);
        element.removeEventListener("keydown", preventMediaSpeedShortcut, true);
        window.clearInterval(intervalId);
    };
}

function setUrlParam(url, key, value) {
    try {
        const parsed = new URL(url, window.location.origin);
        parsed.searchParams.set(key, value);

        return parsed.toString();
    } catch {
        return url;
    }
}

export function processEmbedHtml(html) {
    if (!html) {
        return "";
    }

    const template = document.createElement("div");
    template.innerHTML = html;

    const video = template.querySelector("video");
    if (video) {
        video.classList.add("protected-media-embed__video");
        video.setAttribute("controls", "");
        video.setAttribute("playsinline", "");
        video.setAttribute("controlsList", "nodownload noplaybackrate");

        return template.innerHTML;
    }

    const iframe = template.querySelector("iframe");
    if (!iframe) {
        return html;
    }

    let src = iframe.getAttribute("src") || "";

    if (src.includes("youtube.com") || src.includes("youtu.be")) {
        src = setUrlParam(src, "enablejsapi", "1");
        src = setUrlParam(src, "disablekb", "1");
        src = setUrlParam(src, "modestbranding", "1");
        src = setUrlParam(src, "rel", "0");
        src = setUrlParam(src, "origin", window.location.origin);
        iframe.setAttribute("id", iframe.getAttribute("id") || `yt-embed-${Date.now()}`);
    }

    if (src.includes("player.vimeo.com")) {
        src = setUrlParam(src, "speed", "0");
        src = setUrlParam(src, "keyboard", "0");
    }

    iframe.setAttribute("src", src);
    iframe.classList.add("protected-media-embed__iframe");
    iframe.setAttribute("referrerpolicy", "strict-origin-when-cross-origin");

    return template.innerHTML;
}

let youtubeApiPromise = null;

function loadYouTubeApi() {
    if (window.YT?.Player) {
        return Promise.resolve();
    }

    if (!youtubeApiPromise) {
        youtubeApiPromise = new Promise((resolve) => {
            const previousReady = window.onYouTubeIframeAPIReady;
            window.onYouTubeIframeAPIReady = () => {
                if (typeof previousReady === "function") {
                    previousReady();
                }
                resolve();
            };

            if (!document.querySelector('script[src*="youtube.com/iframe_api"]')) {
                const script = document.createElement("script");
                script.src = "https://www.youtube.com/iframe_api";
                script.async = true;
                document.head.appendChild(script);
            }
        });
    }

    return youtubeApiPromise;
}

let vimeoApiPromise = null;

function loadVimeoApi() {
    if (window.Vimeo?.Player) {
        return Promise.resolve();
    }

    if (!vimeoApiPromise) {
        vimeoApiPromise = new Promise((resolve) => {
            if (document.querySelector('script[src*="player.vimeo.com/api/player.js"]')) {
                const check = setInterval(() => {
                    if (window.Vimeo?.Player) {
                        clearInterval(check);
                        resolve();
                    }
                }, 50);

                return;
            }

            const script = document.createElement("script");
            script.src = "https://player.vimeo.com/api/player.js";
            script.async = true;
            script.onload = () => resolve();
            document.head.appendChild(script);
        });
    }

    return vimeoApiPromise;
}

export async function attachEmbeddedMediaProtection(container) {
    if (!container) {
        return () => {};
    }

    const cleanups = [];

    const videos = container.querySelectorAll("video");
    for (const video of videos) {
        cleanups.push(attachNativeMediaProtection(video));
    }

    const iframes = container.querySelectorAll("iframe");
    for (const iframe of iframes) {
        const src = iframe.getAttribute("src") || "";

        if (src.includes("youtube.com/embed")) {
            await loadYouTubeApi();

            if (!window.YT?.Player) {
                continue;
            }

            const playerId = iframe.getAttribute("id") || `yt-embed-${Date.now()}`;
            iframe.setAttribute("id", playerId);

            const player = new window.YT.Player(playerId, {
                events: {
                    onPlaybackRateChange: (event) => {
                        if (event?.data && event.data !== 1) {
                            event.target.setPlaybackRate(1);
                        }
                    },
                },
            });

            cleanups.push(() => {
                try {
                    player.destroy();
                } catch {
                    //
                }
            });
        }

        if (src.includes("player.vimeo.com")) {
            await loadVimeoApi();

            if (!window.Vimeo?.Player) {
                continue;
            }

            const player = new window.Vimeo.Player(iframe);
            const onRateChange = (data) => {
                if (data?.playbackRate && data.playbackRate !== 1) {
                    player.setPlaybackRate(1).catch(() => {});
                }
            };

            player.on("playbackratechange", onRateChange);
            cleanups.push(() => {
                player.off("playbackratechange", onRateChange).catch(() => {});
            });
        }
    }

    return () => {
        cleanups.forEach((cleanup) => cleanup());
    };
}
