<template>
    <div class="top-categories">
        <div class="top-categories__header text-center">
            <span class="top-categories__badge">
                <i class="bi bi-bar-chart-fill" aria-hidden="true"></i>
                {{ $t('Top Category') }}
            </span>
            <h2 class="top-categories__title">
                {{ $t('Explore Top Courses Categories') }}
                <span class="d-block">{{ $t('That Change Yourself') }}</span>
            </h2>
        </div>

        <div v-if="featuredCategories.length" class="top-categories__grid">
            <router-link
                v-for="category in featuredCategories"
                :key="category.id"
                :to="'/programs?category_id=' + category.id"
                class="category-card text-decoration-none"
            >
                <span class="category-card__icon">
                    <img
                        v-if="category.image"
                        :src="category.image"
                        :alt="category.title"
                        loading="lazy"
                    />
                    <i v-else class="bi bi-grid-fill" aria-hidden="true"></i>
                </span>
                <span class="category-card__name">{{ category.title }}</span>
            </router-link>
        </div>

        <p v-else class="top-categories__empty text-center mb-0">
            {{ $t('Categories coming soon.') }}
        </p>
    </div>
</template>

<style lang="scss" scoped>
.top-categories__header {
    margin-bottom: 2.5rem;
}

.top-categories__badge {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.45rem 1rem;
    margin-bottom: 1rem;
    border-radius: 50px;
    background: #fff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    color: #6b7280;
    font-size: 0.82rem;
    font-weight: 600;

    i {
        color: #9ca3af;
        font-size: 0.9rem;
    }
}

.top-categories__title {
    font-size: clamp(1.65rem, 3.2vw, 2.35rem);
    font-weight: 800;
    color: #111827;
    line-height: 1.25;
    letter-spacing: -0.02em;
    margin: 0;
    max-width: 720px;
    margin-left: auto;
    margin-right: auto;
}

.top-categories__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
}

.category-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.15rem 1.35rem;
    min-height: 88px;
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.06);
    transition: transform 0.25s ease, box-shadow 0.25s ease;

    &:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.1);

        .category-card__name {
            color: #15803d;
        }
    }
}

.category-card__icon {
    flex-shrink: 0;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f3f4f6;

    img {
        width: 28px;
        height: 28px;
        object-fit: contain;
    }

    i {
        font-size: 1.25rem;
        color: #9ca3af;
    }
}

.category-card__name {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.4;
    transition: color 0.2s ease;
}

.top-categories__empty {
    color: #6b7280;
    font-size: 0.95rem;
    padding: 2rem 0;
}

@media (max-width: 991px) {
    .top-categories__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .top-categories__header {
        margin-bottom: 2rem;
    }

    .top-categories__grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .category-card {
        padding: 1rem 1.15rem;
        min-height: 80px;
    }
}
</style>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

const featuredCategories = ref([]);

const fetchFeaturedCategories = async () => {
    try {
        const response = await axios.get(`/categories`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            params: {
                is_featured: true,
                items_per_page: 8,
                page_number: 1,
            },
        });
        featuredCategories.value = response.data.data.categories;
    } catch (error) {
        console.error("Error fetching categories:", error);
    }
};

onMounted(() => {
    fetchFeaturedCategories();
});
</script>
