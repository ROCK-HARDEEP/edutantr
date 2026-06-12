<template>
    <section class="my-2">
        <span class="d-block mb-2 mb-lg-3 fs-4 fw-bold">{{ $t('Home') }}/{{ $t('My Certificates') }}</span>

        <div v-if="uploadedCertificates.length" class="mb-5">
            <h5 class="fw-bold mb-3">{{ $t('Uploaded Certificates') }}</h5>
            <div class="row">
                <div v-for="certificate in uploadedCertificates" :key="'uploaded-' + certificate.id"
                    class="col-sm-6 mb-4">
                    <div class="border theme-shadow rounded">
                        <div class="certificate-info text-white align-items-center justify-content-center d-flex rounded-top"
                            :style="'background-image: url(/assets/images/website/certificate-unlock.png); background-size: cover; background-position: center;'">
                            <div class="text-center px-3">
                                <i class="bi bi-cloud-download-fill display-5 d-block mb-3"></i>
                                <p class="mb-2">{{ $t('Your certificate is ready to download') }}.</p>
                                <a href="#" @click.prevent="downloadUploadedCertificate(certificate)"
                                    class="text-white">
                                    {{ $t('Tap here to Download') }}
                                </a>
                            </div>
                        </div>
                        <div class="certificate-metadata bg-light rounded-bottom px-3 pt-2 pb-3">
                            <span class="fs-5 text-hover">{{ shortTitle(certificate.title) }}</span>
                            <small class="text-muted d-block mt-1">{{ certificate.uploaded_at }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h5 v-if="uploadedCertificates.length" class="fw-bold mb-3">{{ $t('Course Certificates') }}</h5>

        <div class="row mt-3">
            <div v-for="certificate in certificates" class="col-sm-6 mb-4" :key="certificate.id">
                <div v-if="certificate.is_completed" class="border theme-shadow rounded">
                    <div class="certificate-info text-white align-items-center justify-content-center d-flex rounded-top"
                        :style="'background-image: url(' +
                            '/assets/images/website/certificate-unlock.png' +
                            '); background-size: cover; background-position: center;'
                            ">
                        <div class="text-center px-3">
                            <i class="bi bi-cloud-download-fill display-5 d-block mb-3"></i>
                            <p class="mb-2">
                                {{ $t('Your course has been completed and your certificate is now ready') }}.
                            </p>
                            <a href="#" @click="downloadCertificate(certificate.id)" class="text-white">
                                {{ $t('Tap here to Download') }}
                            </a>
                        </div>
                    </div>
                    <div class="certificate-metadata bg-light rounded-bottom px-3 pt-2 pb-3">
                        <router-link :to="'/instructor/' + certificate.instructor.id"
                            class="small text-decoration-none d-block mb-1">{{ certificate.instructor.name
                            }}</router-link>
                        <router-link :to="'/details/' + certificate.id" class="fs-5 text-hover text-decoration-none">{{
                            shortTitle(certificate.title) }}</router-link>
                    </div>
                </div>
                <div v-else class="border theme-shadow rounded">
                    <div class="certificate-info text-white align-items-center justify-content-center d-flex rounded-top"
                        :style="'background-image: url(' +
                            '/assets/images/website/certificate-lock.png' +
                            '); background-size: cover; background-position: center;'
                            ">
                        <div class="text-center px-3">
                            <i class="bi bi-lock-fill text-white display-5 d-block mb-3"></i>
                            <p class="mb-0">
                                {{ $t('The certificate will be unlocked when your course has been finished.') }}
                            </p>
                        </div>
                    </div>
                    <div class="certificate-metadata bg-light rounded-bottom px-3 pt-2 pb-3">
                        <router-link :to="'/instructor/' + certificate.instructor.id"
                            class="small text-decoration-none d-block mb-1">{{ certificate.instructor.name
                            }}</router-link>
                        <router-link :to="'/details/' + certificate.id" class="fs-5 text-hover text-decoration-none">{{
                            shortTitle(certificate.title) }}</router-link>
                    </div>
                </div>
            </div>

            <div v-if="certificates.length === 0 && uploadedCertificates.length === 0" class="col-12">
                <div class="text-center text-muted">
                    <i class="bi bi-emoji-frown display-5"></i>
                    <p class="mb-0 mt-3">{{ $t('No Certificate Available') }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>
.certificate-info {
    height: 200px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.certificate-metadata {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 160px;
}
</style>

<script setup>
import { useAuthStore } from "@/stores/auth";
import { onMounted, ref } from "vue";
const authStore = useAuthStore();

let certificates = ref([]);
let uploadedCertificates = ref([]);

const authHeaders = {
    "Content-Type": "application/json",
    Accept: "application/json",
    Authorization: "Bearer " + authStore.authToken,
};

function normalizeList(items) {
    if (Array.isArray(items)) {
        return items;
    }

    return items?.data ?? [];
}

function loadCertificates() {
    axios.get("/certificate/list", { headers: authHeaders }).then((res) => {
        certificates.value = normalizeList(res.data.data.certificate_courses);
    });

    axios.get("/student-certificate/list", { headers: authHeaders }).then((res) => {
        uploadedCertificates.value = normalizeList(res.data.data.certificates);
    });
}

onMounted(() => {
    loadCertificates();
});

function downloadCertificate(certificateId) {
    axios
        .get(`/certificate/show/${certificateId}`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: "Bearer " + authStore.authToken,
            },
        })
        .then((res) => {
            window.open(res.data.data.url, "_blank");
        });
}

function downloadUploadedCertificate(certificate) {
    if (certificate?.file_url) {
        window.open(certificate.file_url, "_blank");
        return;
    }

    axios
        .get(`/student-certificate/show/${certificate.id}`, { headers: authHeaders })
        .then((res) => {
            window.open(res.data.data.url, "_blank");
        });
}

function shortTitle(title) {
    return title.length > 50 ? title.slice(0, 50) + "..." : title;
}
</script>
