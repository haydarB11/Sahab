<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorBookingData extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $array;
    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.vendor-booking-data')
            ->from($this->array['from'], env('MAIL_FROM_NAME'))
            ->with([
                'booking_id' => $this->array['booking_id'],
                'title' => $this->array['title'],
                'starting_date' => $this->array['starting_date'],
                'ending_date' => $this->array['ending_date'],
                'payment' => $this->array['payment'],
                'name' => $this->array['name'],
            ]);
    }
}

