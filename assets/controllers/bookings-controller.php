<?php
declare(strict_types = 1);

namespace Controllers;

use AppData\Config;
use Models\Booking;
use Models\Tour;
use Controllers\Auth;
use Controllers\Errors as ErrorsController;
use Rendering\View;
use Scripts\Calendar;
use Scripts\EErrors;

class Bookings
{
    private const CCN_RE = '/^[\w\s]{0}\d{4}(-\d{4}){3}$/'; // Credit Card Number

    public static function index (array $request) : View {
        return new View('/main_template.phtml', [
            '{{@title}}' => 'Bookings',
            '{{@links}}' => '<link rel="stylesheet" href="' . Config::get_dirs()->webRoot . '/public/styles/booking.css" />',
            '{{@content}}' => new View('/bookings.phtml', ['{{@bookings}}' => self::bookings_component()], false)
        ]);
    }

    public static function perform_deal (array $request) : void {
        $resp = new \stdClass();
        $resp->status = 'unfinished';

        if (!Auth::is_authed()) {
            $err = EErrors::get('authrequired');

            header($_SERVER['SERVER_PROTOCOL'] . ' ' . $err['headers']['statusCode'] . ' ' . $err['headers']['reason']);

            $resp->data = ErrorsController::get_component($err)->render();
            $resp->reason = new \stdClass();
            $resp->reason->title = $err['title'];
            $resp->reason->msg = $err['msg'];

            echo json_encode($resp);
            
            redirect('location: ', '/auth/signin?err=authrequired');
        }

        $CCNumber = $_POST['CCNumber'];

        if (!isset($CCNumber)) {
            $err = EErrors::get('invalidrequest');

            header($_SERVER['SERVER_PROTOCOL'] . ' ' . $err['headers']['statusCode'] . ' ' . $err['headers']['reason']);

            $resp->data = ErrorsController::get_component($err)->render();
            $resp->reason = new \stdClass();
            $resp->reason->title = $err['title'];
            $resp->reason->msg = $err['msg'];

            echo json_encode($resp);

            return;
        }

        // !
        if (!preg_match(self::CCN_RE, $CCNumber)) {
            $err = EErrors::get('incorrectdata');

            header($_SERVER['SERVER_PROTOCOL'] . ' ' . $err['headers']['statusCode'] . ' ' . $err['headers']['reason']);

            $resp->data = ErrorsController::get_component($err)->render();
            $resp->reason = new \stdClass();
            $resp->reason->title = $err['title'];
            $resp->reason->msg = $err['msg'];

            echo json_encode($resp);

            return;
        }

        $booking = Booking::create((int)$_SESSION['userId'], (int)$_POST['tourId']);

        if (empty($booking)) {
            $err = EErrors::get('duplicate');

            header($_SERVER['SERVER_PROTOCOL'] . ' ' . $err['headers']['statusCode'] . ' ' . $err['headers']['reason']);

            $resp->data = ErrorsController::get_component($err)->render();
            $resp->reason = new \stdClass();
            $resp->reason->title = $err['title'];
            $resp->reason->msg = $err['msg'];

            echo json_encode($resp);

            return;
        }

        header($_SERVER['SERVER_PROTOCOL']  . ' 200 Operation Completed');

        $resp->status = 'deal';

        echo json_encode($resp);
    }

    private static function bookings_component () : string {
        $webRoot = Config::get_dirs()->webRoot;
        $bookings = Booking::get_by(['userId' => ['value' => $_SESSION['userId'], 'type' => \PDO::PARAM_INT]]);

        if (empty($bookings)) {
            ob_start(); ?>

            <div class="err-msg-cntr">
                <h1 class="subtitle">No tours yet</h1>
                <p>Currently you don't have any booked tours.</p>
            </div>

        <?php return ob_get_clean();
        }

        $tour = NULL;
        $date = '';

        ob_start(); ?>

        <h1 class="title">Booked <b>tours</b></h1>
        <ul class="bookings-cntr">
            <?php
            foreach ($bookings as $booking) { 
                $tour = Tour::get_by(['id' => ['value' => $booking->get_tourId(), 'type' => \PDO::PARAM_INT]])[0];
                $date = $tour->get_date();
            ?>
            
            <li>
                <article class="booking-cntr light-shadow">
                    <div class="heading-cntr">
                        <h2 class="subtitle">Tour #<?= $booking->get_tourId(); ?></h2>
                        <span class="separator hr"></span>
                    </div>
                    <div class="content-cntr">
                        <section class="preview-cntr">
                            <div class="pic-cntr">
                                <span class="icon block bg-no-repeat bg-center bg-contain" style="background-image: url('<?= $webRoot . '/public/images' . $tour->get_pic(); ?>');"></span>
                            </div>
                        </section>
                        <h3 class="subtitle"><b>Travelling</b> through <span class="separated"><?= $tour->get_country(); ?></span></h3>
                        <div class="desc-cntr">
                            <section class="desc">
                                <div class="heading-cntr">
                                    <span class="icon block bg-no-repeat bg-center bg-center bg-contain" style="background-image: url('<?= $webRoot; ?>/public/images/icons/destination-pin.svg');"></span>
                                    <h3 class="subtitle">Destinations</h3>
                                </div>
                                <ul class="inline">
                                <?php
                                $destinations = $tour->get_destinations();

                                foreach ($destinations as $destination) { ?>
                                
                                    <li><p><?= $destination; ?></p></li>
                            <?php } ?>
                            
                                </ul>
                            </section>
                            <section class="date-cntr">
                                <section class="desc">
                                    <div class="heading-cntr">
                                        <span class="icon block bg-no-repeat bg-center bg-center bg-contain" style="background-image: url('<?= $webRoot; ?>/public/images/icons/calendar.svg');"></span>
                                        <h3 class="subtitle">Starting date</h3>
                                    </div>
                                    <time datetime="<?= substr($date, 0, 10); ?>" title="<?= substr($date, 0, 10); ?>"><?= Calendar::get_month_name((int)substr($date, 5, 2)) . ' ' . substr($date, 8, 2); ?></time>
                                </section>
                                <section class="desc">
                                    <div class="heading-cntr">
                                        <span class="icon block bg-no-repeat bg-center bg-center bg-contain" style="background-image: url('<?= $webRoot; ?>/public/images/icons/clock.svg');"></span>
                                        <h3 class="subtitle">Time</h3>
                                    </div>
                                    <time><?= $tour->get_time(); ?></time>
                                </section>
                            </section>
                            <section class="desc">
                                <div class="heading-cntr">
                                    <span class="icon block bg-no-repeat bg-center bg-center bg-contain" style="background-image: url('<?= $webRoot; ?>/public/images/icons/duration.svg');"></span>
                                    <h3 class="subtitle">Duration</h3>
                                </div>
                                <p><?= $tour->get_duration(); ?> hours</p>
                            </section>
                            <section class="desc">
                                <div class="heading-cntr">
                                    <h3 class="subtitle">Booked in:</h3>
                                    <time><?= $booking->get_operation_date(); ?></time>
                                </div>
                            </section>
                        </div>
                    </div>
                </article>
            </li>
            <?php } ?>

        </ul>
        <?php return ob_get_clean();
    }
}