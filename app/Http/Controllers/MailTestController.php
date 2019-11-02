<?php

namespace App\Http\Controllers;

use App\Console\Commands\AccountConfirm;
use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Events\AccountCreate;
use App\Events\PriceChange;
use App\Services\AccountConfirmationService;
use App\Services\Base\MailjetV3Service;
use App\Services\Contact\ContactMegaDataService;
use App\Services\Contact\ContactService;
use App\Services\ResetPasswordService;
use App\Templates\Confirmation;
use App\Utils\Common;
use Illuminate\Http\Request;
use Mailjet\Resources;

class MailTestController extends Controller
{
    protected $mjV31;
    protected $mjV3;
    protected $sync;
    protected $contact;

    /**
     * Create a new controller instance.
     *
     * @param MailTransactionalContract $mjV31
     * @param MailCommonContract $mjV3
     * @param ResetPasswordService $sync
     */
    public function __construct(MailTransactionalContract $mjV31, MailCommonContract $mjV3, ResetPasswordService $sync)
    {
        $this->mjV31 = $mjV31;
        $this->mjV3 = $mjV3;
        $this->sync = $sync;
    }

    public function testDependency()
    {
        var_dump($this->mjV31);
    }

    public function testSend(Request $request)

    {
        print_r($request->all());exit;
//        $data = [
//            'subject' => 'test subject',
//            //'fromEmail' => '',
//            'fromName' => '1111',
//            "links"=> [
//                'details' => 'http://www.google.com',
//                "configure"=>"http://www.google.com",
//                "unsubscribe"=>"http://www.google.com"
//            ],
//            "alert" => [
//                "trip_name"=>"11",
//                "ship_name"=>"11",
//                "departure_date"=>"2019/12/12 12:01:12",
//                "prices"=> [
//                    [
//                        'is_drop' => 1,
//                        'cabin_type' =>'1',
//                        'current' => 11.121,
//                        'change_abs' => 1,
//                        'change_rel' => 2,
//                        'updated_at' => '2019/12/12',
//                    ],
//                    [
//                        'is_drop' => 0,
//                        'cabin_type' =>'good cabin',
//                        'current' => 1100,
//                        'change_abs' => 100,
//                        'change_rel' => 2,
//                        'updated_at' => '2019/12/12',
//                    ]
//                ]
//            ],
//            'recipients' =>[
//                [
//                    'email' => 'duyanguk@163.com',
//                    'name' => 'Yang'
//                ],
//                [
//                    'email' => 'duyang48484848@gmail.com',
//                ],
//            ]
//        ];
//        $res = $this->sync->send($data);
//        print_r($res);exit;
        //event(new PriceChange($data));exit;
//        $confirm = new Confirmation();
//        if($confirm->getError()){
//            return $confirm->getError();
//        }
//        $body = $confirm->getBody();
//        //print_r($body);exit;
        $body1 = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "dadas",
                        'Name' => "Cruise Watch"
                    ],
                    'To' => [
                        [
                            'Email' => "duyanguk@163.com",
                            'Name' => "You"
                        ]
                    ],
                    'TemplateID' => 1066812,
                    'TemplateLanguage' => true,
                    'Subject' => "We have a new price alert for you",
                    'Variables' => [
                        "firstname" => "Cruiser",
                        "links"=> [
                            'details' => 'http://www.google.com',
                            "configure"=>"http://www.google.com",
                            "unsubscribe"=>"http://www.google.com"
                        ],
                        "alert" => [
                            "trip_name"=>"11",
                            "ship_name"=>"11",
                            "departure_date"=>"2019/12/12",
                            "prices"=> [
                                [
                                    'is_drop' => 1,
                                    'cabin_type' =>'1',
                                    'current' => 11,
                                    'change_abs' => 1,
                                    'change_rel' => 2,
                                    'updated_at' => '1',
                                ]
                            ]
                        ]
                    ]
                ],
//                [
//                    'From' => [
//                        'Email' => "info@cruisewatch.com",
//                        'Name' => "Cruise Watch"
//                    ],
//                    'To' => [
//                        [
//                            'Email' => "duyang48484848@gmail.com",
//                            'Name' => "You"
//                        ]
//                    ],
//                    'TemplateID' => 1066812,
//                    'TemplateLanguage' => true,
//                    'Subject' => "We have a new price alert for you",
//                    'Variables' => [
//                        "firstname" => "Cruiser",
//                        "links"=> [
//                            'details' => 'http://www.google.com',
//                            "configure"=>"http://www.google.com",
//                            "unsubscribe"=>"http://www.google.com"
//                        ],
//                        "alert" => [
//                            "trip_name"=>"11",
//                            "ship_name"=>"11",
//                            "departure_date"=>"2019/12/12",
//                            "prices"=> [
//                                [
//                                    'is_drop' => 1,
//                                    'cabin_type' =>'1',
//                                    'current' => 11,
//                                    'change_abs' => 1,
//                                    'change_rel' => 2,
//                                    'updated_at' => '1',
//                                ]
//                            ]
//                        ]
//                    ]
//                ]
            ]
        ];
        $response = $this->mjV31->post(Resources::$Email, ['body' => $body1]);
        print_r($response);
        exit;
        //$response->success() && var_dump($response->getData());
    }

    public function testGet()
    {
        $response = $this->mjV3->getClient()->get(Resources::$Message, ['id' => 1152921506578001004]);
        $response->success() && var_dump($response->getData());
    }

    public function testTemp()
    {
        $response = $this->mjV3->getClient()->get(Resources::$Template, ['id' => 850961]);
        print_r($response);exit;
        $response->success() && var_dump($response->getData());
    }

    public function testContact()
    {

        $data = [
            'id' => 1970065886,
            'IsExcludedFromCampaigns' => 1,
            'Name' => "New Contact 1"
        ];
        $megaData = [
            'dataType' => "str",
            'name' => "last_name",
        ];
        $megaUpdateData = [
            'email' => 'duyang48484848@gmail.com',
            'data' => [
                [
                    'Name' => "last_name",
                    'Value' => "Doe2"
                ]
            ]
        ];
        $contact = new ContactMegaDataService($this->mjV3);
        //print_r($contact);exit;
        $res = $contact->update($megaUpdateData);
        print_r($res);exit;
    }
}
