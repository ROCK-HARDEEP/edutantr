<template>
    <section class="my-2">
        <span class="d-block mb-2 mb-lg-3 fs-4 fw-bold">{{ $t('Home') }}/{{ $t('My Certificates') }}</span>

        <div class="row mt-3">
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

            <div v-if="uploadedCertificates.length === 0" class="col-12">
                <div class="text-center text-muted">
                    <i class="bi bi-emoji-frown display-5"></i>
                    <p class="mb-0 mt-3">{{ $t('No Certificate Available') }}</p>
                    <p class="small mt-2">{{ $t('Certificates will appear here once uploaded by the administrator.') }}</p>
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
    axios.get("/student-certificate/list", { headers: authHeaders }).then((res) => {
        uploadedCertificates.value = normalizeList(res.data.data.certificates);
    });
}

onMounted(() => {
    loadCertificates();
});

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
