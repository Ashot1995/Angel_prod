<?php


namespace App\Services;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class YclientsService
{
    private $headers;
    private $bash_url;

    public function __construct() {
        $this->headers = Config::get('yclients.headers');
        $this->bash_url= Config::get('yclients.bash_url');
    }

    //GET | https://api.yclients.com/api/v1/companies
    public function getCompanyList () {
        $response = $this->httpRequest()
            ->get(join('/',[$this->bash_url, 'companies']));

        return $response;
    }

    //GET | https://api.yclients.com/api/v1/company/{company_id}/
    public function getCompanyById (string $id) {
        $response = $this->httpRequest()
            ->get(join('/',[$this->bash_url, 'company', $id]));

        return $response;
    }
    //GET | https://api.yclients.com/api/v1/book_staff/{company_id}
    public function getCompanyStaffs (string $id) {
        $response = $this->httpRequest()
            ->get(join('/',[$this->bash_url, 'book_staff', $id]));

        return $response;
    }
    //GET | https://api.yclients.com/api/v1/book_dates/{company_id}
    public function getBookDates (string $id) {
        $response = $this->httpRequest()
            ->get(join('/',[$this->bash_url, 'book_dates', $id]));

        return $response;
    }
    //GET | https://api.yclients.com/api/v1/book_times/{company_id}/{staff_id}/{date}
    public function bookTimeForDate (string $id, string $staff_id,string $date) {
        $response = $this->httpRequest()
            ->get(join('/',[$this->bash_url, 'book_times', $id, $staff_id, $date]));

        return $response;
    }

    private function httpRequest () {
        return Http::withHeaders($this->headers);
    }
}
