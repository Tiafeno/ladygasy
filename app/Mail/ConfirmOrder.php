<?php

namespace App\Mail;

use App\Models\CustomerBilling;
use App\Models\CustomerModel;
use App\Models\OrderDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class ConfirmOrder extends Mailable
{
	use Queueable, SerializesModels;

	public $address = [];
	public $items = [];
	public $id_order = 0;
	public $total = 0;
	public $order_link = "";

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($order)
	{
		if ($order instanceof Model) {
			$this->id_order = $order->id_order;
			$customer_billing = CustomerBilling::query()->find($order->id_billing);
			if ($customer_billing) {
				$this->address = $customer_billing->toArray();
			}
			$order_details = OrderDetails::query()->where('id_order', '=', $order->id_order)->get();
			$this->items = $order_details->map(fn($k) => $k->toArray())->toArray();
			$this->total = collect($this->items)->sum(fn($i) => $i['product_price'] * $i['product_quantity']);
			$this->order_link = route('confirm.order', ['idc' => Crypt::encryptString((string)$this->id_order)]);
		}
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('Nouveau commande sur le site Ladygasy')
				->replyTo('cedricabezandry@gmail.com', "Cedrica Marie")
				->view('mails.confirm-order', [
						'items' => $this->items,
						'address' => $this->address,
						'total' => $this->total,
						'id' => $this->id_order,
					'order_link' => $this->order_link
				]);
	}
}
