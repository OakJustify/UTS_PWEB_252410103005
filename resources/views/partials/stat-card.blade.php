<article class="cell stat-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index ?? 0) * 50 }}">
    <p class="stat-card__value" data-count>{{ $value }}</p>
    <p class="stat-card__label">{{ $label }}</p>
    <p class="stat-card__hint">{{ $hint }}</p>
</article>
