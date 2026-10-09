<?php
declare(strict_types = 1);

namespace Controllers;

use AppData\Config;
use Models\Attraction;
use Rendering\View;

class Attractions
{
    private const countries = [
        'armenia' => 'Armenia',
        'france' => 'France',
        'usa' => 'USA',
        'italy' => 'Italy'
    ];
    private const RE_LINE_BREAK = '/\r\n|\r|\n/';
    private const PREVIEW_DESC_LENGTH = 330;

    public static function index (array $request) : View {
        if (!empty($request)) {
            return self::country($request);
        }

        $content = '';
        $attractions = Attraction::get_all();

        ob_start(); ?>
        <h1 class="title">Attractions</h1>
        <ul class="attraction-wrapper">
    <?php
        foreach ($attractions as $key => $attraction) { ?>
            <li>
                <article class="attraction-cntr light-shadow">
                    <hgroup class="attraction-desc-cntr">
                        <h2 class="subtitle"><?= $attraction->get_title(); ?></h2>
                        <p class="bold"><?= substr(preg_split(self::RE_LINE_BREAK, $attraction->get_desc(), -1, PREG_SPLIT_NO_EMPTY)[0], 0, self::PREVIEW_DESC_LENGTH); ?>... <a href="<?= Config::get_dirs()->webRoot . '/attraction?id=' . $attraction->get_id(); ?>" class="link">See more</a></p>
                    </hgroup>
                    <div class="attraction-pic-cntr">
                        <img src="<?= Config::get_dirs()->webRoot . '/public/images' . $attraction->get_pic(); ?>" alt="<?= $attraction->get_title(); ?>" class="pic cover" />
                    </div>
                </article>
            </li>
    <?php } ?>
        </ul>
        <?php
        $content = ob_get_clean();

        return new View('/main_template.phtml', [
            '{{@title}}' => 'Attractions',
            '{{@links}}' => '<link rel="stylesheet" href="' . Config::get_dirs()->webRoot . '/public/styles/attractions.css" />',
            '{{@content}}' => $content
        ]);
    }

    public static function attraction (array $request) : View {
        $id = (int)$request['id'];

        $attraction = Attraction::get_by(['id' => ['value' => $id, 'type' => \PDO::PARAM_INT]]);

        if (empty($attraction)) {
            header('HTTP/1.0 404 Not Found');
            redirect('location: ', '/error');
        } else {
            $attraction = $attraction[0];
        }

        $matches = preg_split(self::RE_LINE_BREAK, $attraction->get_desc(), -1, PREG_SPLIT_NO_EMPTY);
        $desc = '';

        foreach ($matches as $key => $value) {
            $desc .= '<p>' . $value . '</p>';
        }

        return new View('/main_template.phtml', [
            '{{@title}}' => 'Home page',
            '{{@links}}' => '<link rel="stylesheet" href="' . Config::get_dirs()->webRoot . '/public/styles/attractions.css" />',
            '{{@content}}' => new View('/attraction.php', [
                '{{@attr-title}}' => $attraction->get_title(),
                '{{@attr-desc}}' => $desc,
                '{{@attr-pic}}' => $attraction->get_pic()
            ], false)
        ]);
    }

    public static function country (array $request) : View {
        if (empty($request['country'])) {
            redirect('location: ', '/error?notfound');
        }

        $countryName = $request['country'];

        $attractions = Attraction::get_by(['country' => ['value' => $countryName, 'type' => \PDO::PARAM_STR]]);

        if (empty($attractions)) {
            redirect('location: ', '/error?notfound');
        }

        $countryName = self::countries[$countryName];
        $content = '';

        ob_start(); ?>
        <h1 class="title">Attractions of <?= $countryName; ?></h1>
        <ul class="attraction-wrapper">
    <?php
        foreach ($attractions as $key => $attraction) { ?>
            <li>
                <article class="attraction-cntr light-shadow">
                    <hgroup class="attraction-desc-cntr">
                        <h2 class="subtitle"><?= $attraction->get_title(); ?></h2>
                        <p class="bold"><?= substr(preg_split(self::RE_LINE_BREAK, $attraction->get_desc(), -1, PREG_SPLIT_NO_EMPTY)[0], 0, self::PREVIEW_DESC_LENGTH); ?>... <a href="<?= Config::get_dirs()->webRoot . '/attraction?id=' . $attraction->get_id(); ?>" class="link">See more</a></p>
                    </hgroup>
                    <div class="attraction-pic-cntr">
                        <img src="<?= Config::get_dirs()->webRoot . '/public/images' . $attraction->get_pic(); ?>" alt="<?= $attraction->get_title(); ?>" class="pic cover" />
                    </div>
                </article>
            </li>
    <?php } ?>
        </ul>
        <?php
        $content = ob_get_clean();

        return new View('/main_template.phtml', [
            '{{@title}}' => $countryName,
            '{{@links}}' => '<link rel="stylesheet" href="' . Config::get_dirs()->webRoot . '/public/styles/attractions.css" />',
            '{{@content}}' => $content
        ]);
    }

    public static function get_top (int $count = 10) : string {
        $attractions = Attraction::get_top($count);
        
        $webRoot = Config::get_dirs()->webRoot;

        ob_start(); ?>
        <ol class="content-cntr">
        <?php foreach ($attractions as $key => $attraction) { ?>
            <li class="item-cntr">
                <span class="hr <?= $attraction->get_country(); ?>"></span>
                <article class="content-cntr">
                    <h2 class="name"><?= $attraction->get_title(); ?></h2>
                    <header class="preview-cntr">
                        <a href="<?= $webRoot; ?>/attraction?id=<?= $attraction->get_id(); ?>">
                            <img src="<?= $webRoot . '/public/images' . $attraction->get_pic(); ?>" alt="<?= $attraction->get_title(); ?>" class="pic cover" title="<?= $attraction->get_title(); ?>" />
                        </a>
                    </header>
                </article>
            </li>
        <?php } ?>
        </ol>
        <?php
        $result = ob_get_clean();

        return $result;
    }
}