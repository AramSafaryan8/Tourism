<article class="attraction-cntr">
    <div class="heading-cntr">
        <h1 class="title cover back">{{@attr-title}}</h1>
        <div class="attraction-pic-cntr">
            <img src="<?= $dirs->webRoot; ?>/public/images{{@attr-pic}}" alt="{{@attr-title}}" class="pic cover" title="{{@attr-title}}" />
        </div>
    </div>
    <article class="attraction-desc-cntr">
        <h2 class="subtitle">{{@attr-title}}: in more details</h2>
        {{@attr-desc}}
    </article>
</article>