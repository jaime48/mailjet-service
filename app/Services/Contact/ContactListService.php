<?php

namespace App\Services\Contact;

use App\Contracts\MailCommonContract;
use App\Models\Contact;
use App\Models\ContactList;
use App\Utils\Common;
use Mailjet\Resources;

class ContactListService
{
    use Common;

    protected $mjV3;

    public function __construct(MailCommonContract $mjV3)
    {
        $this->mjV3 = $mjV3;
    }

    public function create($data)
    {
        $res = ContactList::validateCreate($data);
        if(!$res['status']){
            return $this->response(false, $res['msg']);
        }
        $res = $this->mjV3->post(Resources::$Contactslist, ['body' => [
            'Name'  =>  $data['name'],
        ]]);
        return $this->formatResponse($res);
    }

    public function getAll()
    {
        $res = $this->mjV3->get(Resources::$Contactslist);
        return $this->formatResponse($res);
    }

    public function get($id)
    {
        $res = $this->mjV3->get(Resources::$Contactslist, ['id' => $id]);
        return $this->formatResponse($res);
    }

    public function update($data)
    {
        $res = ContactList::validateUpdate($data);
        if(!$res['status']){
            return $this->response(false, $res['msg']);
        }
        $res = $this->mjV3->put(Resources::$Contactslist, ['id' => $data['id'], 'body' => [
            'Name' => $data['name']
        ]]);
        return $this->formatResponse($res);
    }

    public function contactsManagement($data)
    {
        $res = ContactList::validateContactsManagement($data);
        if(!$res['status']){
            return $this->response(false, $res['msg']);
        }
        $res = $this->mjV3->post(Resources::$ContactManagemanycontacts, [ 'body' =>
            $res['data']
        ]);
        return $this->formatResponse($res);
    }



}
