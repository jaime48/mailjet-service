<?php

namespace App\Services\Contact;

use App\Contracts\MailCommonContract;
use App\Models\Contact;
use App\Utils\Common;
use Mailjet\Resources;

class ContactService
{
    use Common;

    protected $mjV3;

    public function __construct(MailCommonContract $mjV3)
    {
        $this->mjV3 = $mjV3;
    }

    public function create($data)
    {
        $res = Contact::validateCreate($data);
        if(!$res->getStatus()){
            return $res->format();
        }
        $res = $this->mjV3->post(Resources::$Contact, ['body' => [
            'Email' =>  $data['email'],
            'Name'  =>  isset($data['name']) ? $data['name'] : '',
            'IsExcludedFromCampaigns' => isset($data['isExcludedFromCampaigns']) ? $data['isExcludedFromCampaigns'] : true
        ]]);
        return $res->format();
    }

    public function getAll()
    {
        $res = $this->mjV3->get(Resources::$Contact);
        return $res->format();

    }

    public function get($id)
    {
        $res = $this->mjV3->get(Resources::$Contact, ['id' => $id]);
        return $res->format();
    }

    public function update($data)
    {
        $res = Contact::validateUpdate($data);
        if(!$res->getStatus()){
            return $res->format();
        }
        $res = $this->mjV3->put(Resources::$Contact, ['id' => $data['email'], 'body' => $res->getResponse()]);
        return $res->format();
    }



}
