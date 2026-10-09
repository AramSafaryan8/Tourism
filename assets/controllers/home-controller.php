<?php
declare(strict_types = 1);

namespace Controllers;

use AppData\Config;
use Models\Tour;
use Controllers\Attractions;
use Rendering\View;
use Scripts\Calendar;

class Home
{
    public static function index (array $request) : View {
        $dirs = Config::get_dirs();
        $links = '';

        ob_start(); ?>
        <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/slider.css" />
        <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/chart.css" />
        <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/popup.css" />
        <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/countries.css" />
        <link rel="stylesheet" href="<?= $dirs->webRoot; ?>/public/styles/tours.css" />
        <?php
        $links = ob_get_clean(); ?>
        <script src="<?= $dirs->scripts; ?>/js/slider.js" defer="defer"></script>
        <script src="<?= $dirs->scripts; ?>/js/popup.js" defer="defer"></script>
        <script src="<?= $dirs->scripts; ?>/js/validation.js" defer="defer"></script>
        <script src="<?= $dirs->scripts; ?>/js/lazy-anim.js" defer="defer"></script>
        <?php
        $scripts = ob_get_clean();

        return new View('/main_template.phtml', [
            '{{@title}}' => 'Home page',
            '{{@links}}' => $links,
            '{{@scripts}}' => $scripts,
            '{{@content}}' => new View('/home.phtml', [
                '{{@top-rated-places}}' => Attractions::get_top(),
                '{{@tours}}' => new View('#', [
                    '#' => self::tours_component(),
                    '{{@booking-logic}}' => !isset($_SESSION['token']) ? ' onclick="window.location.href = `${window.location.protocol}' . $dirs->webRoot . '/auth/signin?err=authrequired`;"' : ''
                ], false)
            ], false),
            '{{@popup}}' => self::booking_component()
        ]);
    }

    private static function booking_component () : View {
        $username = (!isset($_SESSION['username']) || empty($_SESSION['username'])) ? 'NOT SPECIFIED' : $_SESSION['username'];

        return (isset($_SESSION['token'])) ? new View('/booking-popup.phtml', [
            '{{@user-email}}' => $_SESSION['email'],
            '{{@user-username}}' => $username
            ]) : new View('', [], false);
    }

    private static function tours_component () : string {
        $dirs = Config::get_dirs();
        $components = '';
        $tours = Tour::get_all();
        $date = '';

        ob_start(); ?>
<ul class="content-cntr">
    <?php foreach ($tours as $tour) { $date = explode(' ', $tour->get_date()); ?>
    <li>
        <article class="tour-cntr light-shadow">
            <h2 class="subtitle"><b>Tour</b> #<?= $tour->get_id(); ?></h2>
            <div class="content-cntr">
                <div class="pic-cntr">
                    <span class="tour-graphic inline-block pic bg-contain bg-no-repeat bg-center" style="background-image: url('<?= $dirs->webRoot; ?>/public/images<?= $tour->get_pic(); ?>');"></span>
                </div>
                <div class="desc-cntr">
                    <section class="field">
                        <h3 class="thin">Country: </h3>
                        <p class="thin"><span class="marked dominanta bold"><?= $tour->get_country(); ?></span></p>
                    </section>
                    <section class="field destinations">
                        <h3 class="thin">Destinations: </h3>
                        <ol class="numbered inline">
                        <?php
                        $destinations = $tour->get_destinations();

                        foreach ($destinations as $place) { ?>
                            <li><p class="thin"><span class="marked dominanta bold"><?= $place; ?></span></p></li>
                        <?php } ?>
                        </ol>
                    </section>
                    <section class="field">
                        <h3 class="thin">Starts: </h3>
                        <time datetime="<?= $date[0] . 'T' . $date[1]; ?>"><span class="marked dominanta bold"><?= Calendar::get_month_name((int)substr($date[0], 5, 2)) . ' ' . substr($date[0], -2); ?></span> | <?= $tour->get_time(); ?></time>
                    </section>
                    <section class="field">
                        <h3 class="thin">Duration: </h3>
                        <p class="thin"><span class="marked dominanta bold"><?= $tour->get_duration(); ?> hours</span></p>
                    </section>
                    <button type="button" class="btn ticket"{{@booking-logic}} data-id="<?= $tour->get_id(); ?>">
                        <span class="block icon bg-contain bg-norepeat bg-center" style="background-image: url('<?= $dirs->webRoot; ?>/public/images/icons/ticket.svg');"></span>TO BOOK
                    </button>
                </div>
            </div>
        </article>
    </li>
    <?php } ?>
</ul>
    <?php return $components = ob_get_clean();
    }
}