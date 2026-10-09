<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{@metas}}
    <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/fonts.css" />
    <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/general.css" />
    <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/header.css" />
    <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/content.css" />
    <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/error.css" />
    <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/footer.css" />
    <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/queries.css" />
    {{@links}}
    {{@scripts}}
    <script src="<?= $dirs->scripts; ?>/js/main.js" defer="defer"></script>
    <title>Tourism | {{@title}}</title>
</head>