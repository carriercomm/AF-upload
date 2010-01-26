<?php
/**
 * Copyright (C) 2006 by Broadwick.
 * 
 * This would be some really fancy legalese if we were concerned about that sort of stuff right now.  Mainly,
 * we guarantee nothing.  You should use this at your own risk.  
 * 
 * @version $Id: IcResource_Contact.php 9504 2008-11-12 22:25:03Z amchardy $
 * @package IcApi
 */


require_once 'IcResource.php';

/**
 * This class represents the contact resource in the iContact API.
 *
 * @author acox@broadwick.com
 */
class IcResource_Contact extends IcResource {
    
    private $contact_id;
    private $what_to_get;
    private $subscription_id;
    private $custom_field_name;

    
    public function getContactId() {
        return $this->contact_id;
    }
    
    public function getLocation() {
        $contact_id = $this->getContactId();
        if($contact_id > 0) {
            if($this->what_to_get == 'subscription') {
                return "{$this->getName()}/$contact_id/{$this->what_to_get}/{$this->subscription_id}";
            } elseif($this->what_to_get == 'custom_field') {
                return "{$this->getName()}/$contact_id/{$this->what_to_get}/{$this->custom_field_name}";
            } elseif($this->what_to_get != null) {
                return "{$this->getName()}/$contact_id/{$this->what_to_get}";
            } else {
                return "{$this->getName()}/$contact_id";
            }
        } else {
            return "{$this->getName()}";
        }
    }
    
    public function getCustomFields() {
        $this->what_to_get = "custom_fields";
    }
    
    public function putCustomFieldValue() {
        $this->what_to_get = "custom_field";
    }
    
    public function getSubscription() {
        $this->what_to_get = "subscription";
    }
    
    public function putSubscription() {
        $this->what_to_get = "subscription";
    }
    
    public function getSubscriptions() {
        $subscription_id = null;
        $this->what_to_get = "subscriptions";
    }
    
    public function setXml(DOMDocument $xml) {
        parent::setXml($xml);
    	 
        $nodelist = $this->xml->getElementsByTagName("contact");
        if($nodelist->length === 0) {
            throw new Exception("Couldn't locate contact resource in xml");
        }
        $contact = $nodelist->item(0);
        if ($contact->hasAttribute("id")) {
        	 $id = $contact->getAttributeNode("id")->nodeValue;
        	 $this->setContactId($id);
        }
        
    }

    public function getName() {
        return "contact";
    }
    
    public function setContactId($contact_id) {
        $subscription_id = null;
        $this->contact_id = $contact_id;
    }

    public function setSubscriptionId($subscription_id) {
        $this->subscription_id = $subscription_id;
    }
    
    public function newContact($email, $fname='', $lname='', $business='', $prefix='', $suffix='', $address1='',
                             $address2='', $city='', $state='', $zip='', $phone='', $fax='') {

        $subscription_id = null;
        $this->setContactId(0);
        if(strlen($email) == 0) {
            throw new Exception("Invalid Email Address");
        }

        $xml = new DOMDocument();
        $contact = $xml->createElement("contact");
        $xml->appendChild($contact);
        $email = $xml->createElement('email',$email);
        $contact->appendChild($email);
        $fname = $xml->createElement('fname',$fname);
        $contact->appendChild($fname);
        $lname = $xml->createElement('lname',$lname);
        $contact->appendChild($lname);
        $business = $xml->createElement('business',$business);
        $contact->appendChild($business);
        $prefix = $xml->createElement('prefix',$prefix);
        $contact->appendChild($prefix);
        $suffix = $xml->createElement('suffix',$suffix);
        $contact->appendChild($suffix);
        $address1 = $xml->createElement('address1',$address1);
        $contact->appendChild($address1);
        $address2 = $xml->createElement('address2',$address2);
        $contact->appendChild($address2);
        $city = $xml->createElement('city',$city);
        $contact->appendChild($city);
        $state = $xml->createElement('state',$state);
        $contact->appendChild($state);
        $zip = $xml->createElement('zip',$zip);
        $contact->appendChild($zip);
        $phone = $xml->createElement('phone',$phone);
        $contact->appendChild($phone);
        $fax = $xml->createElement('fax',$fax);
        $contact->appendChild($fax);
        $this->setXml($xml);
    }


    public function newSubscription($sub_id, $sub_status) {
        $this->subscription_id = $sub_id;
        $xml = new DOMDocument();
        $subscription = $xml->createElement("subscription");
        $subscription->setAttribute("id", $sub_id);
        $xml->appendChild($subscription);
        $status = $xml->createElement("status",$sub_status);
        $subscription->appendChild($status);
        parent::setXml($xml);
    }

    public function newCustomFieldValue($name, $value) {
        $this->custom_field_name = $name;
        $xml = new DOMDocument();
        $custom_field = $xml->createElement("custom_field");
        $custom_field->setAttribute("name", $name);
        $xml->appendChild($custom_field);
        $custom_field_value = $xml->createElement("value", $value);
        $custom_field->appendChild($custom_field_value);
        
        parent::setXml($xml);
    }
    
    public function updateContact($contactid, $email, $fname='', $lname='', $business='', $prefix='', $suffix='', $address1='',
                             $address2='', $city='', $state='', $zip='', $phone='', $fax='') {

        $subscription_id = null;
        $this->setContactId($contactid);
        if($email->length === 0) {
            throw new Exception("Invalid Email Address");
        }

        $xml = new DOMDocument();
        $contact = $xml->createElement("contact");
        $xml->appendChild($contact);
        $email = $xml->createElement('email',$email);
        $contact->appendChild($email);
        $fname = $xml->createElement('fname',$fname);
        $contact->appendChild($fname);
        $lname = $xml->createElement('lname',$lname);
        $contact->appendChild($lname);
        $business = $xml->createElement('business',$business);
        $contact->appendChild($business);
        $prefix = $xml->createElement('prefix',$prefix);
        $contact->appendChild($prefix);
        $suffix = $xml->createElement('suffix',$suffix);
        $contact->appendChild($suffix);
        $address1 = $xml->createElement('address1',$address1);
        $contact->appendChild($address1);
        $address2 = $xml->createElement('address2',$address2);
        $contact->appendChild($address2);
        $city = $xml->createElement('city',$city);
        $contact->appendChild($city);
        $state = $xml->createElement('state',$state);
        $contact->appendChild($state);
        $zip = $xml->createElement('zip',$zip);
        $contact->appendChild($zip);
        $phone = $xml->createElement('phone',$phone);
        $contact->appendChild($phone);
        $fax = $xml->createElement('fax',$fax);
        $contact->appendChild($fax);

        $this->setXml($xml);
    }
	
	/* modified new contact TF 2-09-09 */
	    public function newContact_invite($email, $fname='', $invite_link='',$lname='', $business='', $prefix='', $suffix='', $address1='',
                             $address2='', $city='', $state='', $zip='', $phone='', $fax='') {

        $subscription_id = null;
        $this->setContactId(0);
        if(strlen($email) == 0) {
            throw new Exception("Invalid Email Address");
        }

        $xml = new DOMDocument();
        $contact = $xml->createElement("contact");
        $xml->appendChild($contact);
        $email = $xml->createElement('email',$email);
        $contact->appendChild($email);
        $fname = $xml->createElement('fname',$fname);
        $contact->appendChild($fname);
		/*modified*/
		$invite_link = $xml->createElement('invite_link',$invite_link);
        $contact->appendChild($invite_link);
		/* end modified*/
        $lname = $xml->createElement('lname',$lname);
        $contact->appendChild($lname);
        $business = $xml->createElement('business',$business);
        $contact->appendChild($business);
        $prefix = $xml->createElement('prefix',$prefix);
        $contact->appendChild($prefix);
        $suffix = $xml->createElement('suffix',$suffix);
        $contact->appendChild($suffix);
        $address1 = $xml->createElement('address1',$address1);
        $contact->appendChild($address1);
        $address2 = $xml->createElement('address2',$address2);
        $contact->appendChild($address2);
        $city = $xml->createElement('city',$city);
        $contact->appendChild($city);
        $state = $xml->createElement('state',$state);
        $contact->appendChild($state);
        $zip = $xml->createElement('zip',$zip);
        $contact->appendChild($zip);
        $phone = $xml->createElement('phone',$phone);
        $contact->appendChild($phone);
        $fax = $xml->createElement('fax',$fax);
        $contact->appendChild($fax);
        $this->setXml($xml);
    }
}
?>
