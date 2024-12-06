<?php

namespace App\Http\Controllers;

use ECUApp\SharedCode\Models\Credit;
use ECUApp\SharedCode\Models\Price;
use ECUApp\SharedCode\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Facades\Invoice;
use PDF;

class InvoicesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $invoices = Credit::orderBy('created_at', 'desc')->where('user_id', $user->id)->whereNotNull('stripe_id')->get();
        return view('invoices', ['invoices' => $invoices, 'user' => $user]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showPDF()
    {
        $invoice = Credit::findOrFail(13);
        return view('files.pdf', ['invoice' => $invoice]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function makePDF(Request $request)
    {
        $invoice = Credit::findOrFail($request->id);
        $price = Price::where('label', 'credit_price')->whereNull('subdealer_group_id')->first();
        $user = User::findOrFail($invoice->user_id);

        if($invoice->type == 'stripe'){
            $account = $user->stripe_payment_account();
        }
        else{
            $account = $user->paypal_payment_account();
        }
        
        $client = new Party([
            'name'          => $account->senders_name,
            'phone'         => $account->senders_phone_number,
            'vat'         => $account->company_id,
            'code'         => $account->zip,
            'city'         => $account->city,
            'country'         => $account->country,
            'custom_fields' => [
                'company'         => $account->company,
                'address'        => $account->senders_address,
            ],
        ]);

        $customer = new Party([
            'name'          => $user->name,
            'vat'       => $user->company_id,
            'code'       => $user->zip,
            'city'       => $user->city,
            'country'       => $user->country,
            'phone'         => $user->phone,
            'custom_fields' => [
                'company'         => $user->company_name,
                'address'        => $user->address,
            ],
        ]);

        if($invoice->is_package){

            // $discount = ($invoice->credits * $price->value) - $invoice->price_payed;

            $items = [
                (new InvoiceItem())
                    ->title('Tuning Credits Package')
                    ->description('You can use these credits to buy the services.')
                    ->pricePerUnit($invoice->price_without_tax)
                    ->quantity(1)
                    ->tax($invoice->tax),
                   
            ];
        }
        else{

            $items = [
                (new InvoiceItem())
                    ->title('Tuning Credits')
                    ->description('You can use these credits to buy the services.')
                    ->pricePerUnit($price->value)
                    ->quantity($invoice->credits)
                    ->tax($invoice->tax),
            ];

        }

        $notes = [
            $account->note,
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('invoice')
            ->series($invoice->invoice_id)
            ->status(__('invoices::invoice.paid'))
            ->serialNumberFormat('{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->dateFormat('d/m/Y')
            // ->payUntilDays(14)
            ->currencySymbol('€')
            ->currencyCode('EUR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($invoice->invoice_id)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('/../../backend/public/company_logos/'.$account->companys_logo))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        // $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->download();
    
    }
}
