<?php
namespace App\Livewire\Phpcat\Services;

use Livewire\Component;

class GeneratorQr extends Component
{
	public $text = '';
	public $phone = '';
	public $email = '';
	public $url = '';
	public $img = '';
	public $img_url = '';
	public $type = 'url'; // Тип кода по умолчанию — ссылка на сайт
	public $smsMessage = ''; // Текст SMS
	public $emailSubject = ''; // Тема email
	public $emailMessage = ''; // Текст email


	// Поля для vCard
	public $firstName = '';
	public $lastName = '';
//	public $phone = '';
//	public $email = '';
	public $company = '';
	public $jobTitle = '';
	public $address = '';
	public $website = '';

	// Метод для сброса $img при изменении типа
	public function updatedType()
	{
		$this->img = '';  // Очистка переменной $img
//		$this->text =
//		$this->phone =
//		$this->email =
//		$this->url =
//		$this->img_url =
//		$this->smsMessage =  // Текст SMS
//		$this->emailSubject =  // Тема email
//		$this->emailMessage = ''; // Текст email
		$this->reset(['text', 'emailMessage', 'smsMessage', 'emailSubject', 'url', 'img_url', 'firstName', 'lastName', 'phone', 'email', 'company', 'jobTitle', 'address', 'website']);

	}

	public function generate()
	{
		switch ($this->type) {
			case 'url':
//				$this->img_url = $this->url;
				$this->img = '/api/qr?uri=' . urlencode($this->url);
				break;

			case 'email':
//				$this->img_url = "mailto:{$this->email}?subject=" . urlencode($this->emailSubject) . "&body=" . urlencode($this->emailMessage);
				$this->img_url = "";
				$this->img = '/api/qr?uri=' . urlencode("mailto:{$this->email}&subject=" . urlencode($this->emailSubject) . "&body=" . urlencode($this->emailMessage));
				break;

			case 'sms':
//				$this->img_url = "sms:{$this->phone}?body=" . urlencode($this->smsMessage);
				$this->img_url = "";
				$this->img = '/api/qr?uri=' . urlencode("sms:{$this->phone}&body=" . urlencode($this->smsMessage));
				break;

			case 'vcard':
				$vcard = "BEGIN:VCARD\nVERSION:3.0\n";
				$vcard .= "N:{$this->lastName};{$this->firstName}\n";
				$vcard .= "FN:{$this->firstName} {$this->lastName}\n";
				$vcard .= "ORG:{$this->company}\n";
				$vcard .= "TITLE:{$this->jobTitle}\n";
				$vcard .= "TEL:{$this->phone}\n";
				$vcard .= "EMAIL:{$this->email}\n";
				$vcard .= "ADR:;;{$this->address}\n";
				$vcard .= "URL:{$this->website}\n";
				$vcard .= "END:VCARD";

				$this->img_url = $vcard;
				$this->img = '/api/qr?vcard=' . urlencode($vcard);
				break;

//			default:
////				$this->img_url = '';
////				$this->img = '';
//				$this->img = '/api/qr?uri=' . urlencode($this->url);
//				break;
		}
	}

	public function render()
	{
		return view('livewire.phpcat.services.generator-qr');
	}
}
