<?php

namespace App\Controllers\Course;

use App\Controllers\BaseController;

class Member extends BaseController
{

    public function __construct() {
        $user = session()->get('logged_usercourse');
        
        if (!isset($user) || $user->role != 'member') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    

    public function index() {
        return redirect()->to(BASE_URL . 'course/member/explore');
    }

    public function explore() {        
        $mdata = [
            'title'     => 'Course - ' . NAMETITLE,
            'content'   => 'course/member/index',
            'extra'   => 'course/member/js/_js_index',
            'active_explore'    => 'active',
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function detail_course($id) {
        $url = URL_COURSE . "/v1/course/course_byid?id=".base64_decode($id);
        $response = courseAdmin($url);
        $result = $response->result;
        $course = [];

        if($result->code == 200) {
            $course = $result->message;
        }

        $mdata = [
            'title'     => 'Detail Course - ' . NAMETITLE,
            'content'   => 'course/member/detail',
            'active_explore'    => 'active',
            'course'    => $course
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function live() {

        $mdata = [
            'title'     => 'Live Course - ' . NAMETITLE,
            'content'   => 'course/member/live',
            'extra'     => 'course/member/js/_js_live',
            'active_live'    => 'active',
        ];

        return view('course/layout/wrapper', $mdata);
    }


    public function mycourse() {

        $mdata = [
            'title'     => 'Live Course - ' . NAMETITLE,
            'content'   => 'course/member/my/course',
            'menu'      => 'course/member/my/menu',
            'category'      => 'course/member/my/sidebar',
            'active_learning'    => 'active',
            'active_course'    => 'active',
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function mycertificate() {

        $mdata = [
            'title'     => 'Live Course - ' . NAMETITLE,
            'content'   => 'course/member/my/certificate',
            'menu'      => 'course/member/my/menu',
            'category'      => 'course/member/my/sidebar',
            'active_learning'    => 'active',
            'active_cert'    => 'active',
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function mydemo() {
        $url        = URL_COURSE . "/v1/demo/balance?id=".$_SESSION["logged_usercourse"]->id;
        $response   = courseAdmin($url);

        $balance    = $response->result->message;
        
        $url_history = URL_COURSE . "/v1/demo/trade_history?id=".$_SESSION["logged_usercourse"]->id;
        $rhistory    = courseAdmin($url_history);
        $history     = $rhistory->result->message;

        $mdata = [
            'title'     => 'Trade Course - ' . NAMETITLE,
            'extra'     => 'course/member/js/_js_demo',
            'content'   => 'course/member/my/demo',
            'menu'      => 'course/member/my/menu',
            'active_learning'   => 'active',
            'active_demo'       => 'active',
            'istrade'           => true,
            'balance'           => $balance,
            'history'           => $history
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function wishlist() {
        $course = [
            'title' => 'Analysis Pattern',
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, expedita.",
            'image' => BASE_URL . 'assets/img/course/course-1.png',
            'author' => 'AC'
        ];

        $courses = array_map(function($index) use ($course) {
            $course['id'] = $index;
            return $course;
        }, range(1, 10));
        
        $mdata = [
            'title'     => 'Course - ' . NAMETITLE,
            'content'   => 'course/member/wishlist',
            'courses' => $courses
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function joinlive() {

        $user = session()->get('logged_usercourse');
        $mdata = [
            'title'     => 'Live Course - ' . NAMETITLE,
            'content'   => 'course/member/liveroom',
            'extra'   => 'course/member/js/_js_liveroom',
            'active_live'    => 'active',
            'user'    => $user->name ?? 'Anonym',
            'liveroom' => 'd-none'
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function getall_course()
    {
        $url = URL_COURSE . "/v1/course/all_course";
        $response = courseAdmin($url);
        $result = $response->result;
    
        $data = [
            'code' => $result->code,
            'message' => $result->message ?? [],
        ];
    
        return $this->response->setJSON($data);
    }
    
    public function get_live()
    {
        $url = URL_COURSE . "/v1/live/active_live";
        $response = courseAdmin($url);
        $result = $response->result;

        $data = [
            'code' => $result->code,
            'message' => $result->message ?? [],
        ];
    
        return $this->response->setJSON($data);
    }
    
    public function buyposition(){
        $request = $this->request->getPost();
        if (empty($request['buytype'])) {
            $request['buytype'] = 'limit';
        }
        
        $rules = $this->validate([
            'buytype' => [
                'label' => 'Order Type',
                'rules' => 'required|in_list[limit,market]'
            ],
            'price' => [
                'label' => 'Price',
                'rules' => 'required'
            ],
            'balance' => [
                'label' => 'Available Balance',
                'rules' => 'required'
            ],
            'market-price' => [
                'label' => 'Market Price',
                'rules' => 'required'
            ],
            'usdtAmount' => [
                'label' => 'Amount',
                'rules' => 'required'
            ],
        ]);

        if (!$rules) {
            session()->setFlashdata('failed', $this->validator->listErrors());
            return redirect()->to(BASE_URL . 'course/member/mydemo')->withInput();
        }


        $url = URL_COURSE . "/v1/demo/balance?id=".$_SESSION["logged_usercourse"]->id;
        $response = courseAdmin($url)->result->message;
        $balance    = $response->available_balance ?? 0;

        $price      = str_replace(',', '', $this->request->getVar('price'));
        $balance      = str_replace(',', '', $this->request->getVar('balance'));
        $market_price  = str_replace(',', '', $this->request->getVar('market-price'));
        $usdtAmount = str_replace(',', '', $this->request->getVar('usdtAmount'));
        $tpsl       = $this->request->getVar('tpsl');
        $tplimit  = (float) str_replace(',', '', $this->request->getVar('tplimit'));
        $sllimit  = (float) str_replace(',', '', $this->request->getVar('sllimit'));
        
        $tpValue = null;
        $slValue = null;

        // rule
        if($usdtAmount > $balance) {
            session()->setFlashdata('failed', "Insufficient balance.");
            return redirect()->to(BASE_URL . 'course/member/mydemo')->withInput();
        }
        if($price > $market_price) {
            session()->setFlashdata('failed', "Entry price must be lower than market price");
            return redirect()->to(BASE_URL . 'course/member/mydemo')->withInput();
        }
        
        if ($tpsl) {
            $tpValue = $tplimit > 0 ? $tplimit : null;
            $slValue = $sllimit > 0 ? $sllimit : null;

            // Validasi TP harus > market
            if ($tpValue !== null && $tpValue <= $market_price) {
                session()->setFlashdata('failed', 'Take Profit must be greater than market price.');
                return redirect()->back()->withInput();
            }

            // Validasi SL harus < entry
            if ($slValue !== null && $slValue >= $price) {
                session()->setFlashdata('failed', 'Stop Loss must be lower than entry price.');
                return redirect()->back()->withInput();
            }
            // eksekusi order sell
            
        }
        if (bccomp($usdtAmount, $balance, 8) === 1) {
            session()->setFlashdata('failed', "Insufficient Balance");
            return redirect()->to(BASE_URL . 'course/member/mydemo')->withInput();
        }
        

        $mdata = [
            'trade_id'    => $response->trade_id,
            'user_id'     => $_SESSION["logged_usercourse"]->id,
            'order_price' => $price,
            'usdt_qty'    => $usdtAmount,
            'order_type'  => "buy",
            'trade_type'  => $request['buytype'],
            'take_profit' => $tpValue,
            'stop_loss'   => $slValue,
            'status'      => ($request['buytype']==='market') ? 'filled' : 'pending'
        ];
        
        $url = URL_COURSE . "/v1/demo/trade_buy";
        $result = courseAdmin($url, json_encode($mdata))->result;

        if ($result->code != 200) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'course/member/mydemo')->withInput();
        }
        
        
        $memory = $result->message;
        $this->redis->rpush("orders:BTCUSDT", json_encode($memory));
        
        session()->setFlashdata('success', "Order Successfully Created");
        return redirect()->to(BASE_URL . 'course/member/mydemo')->withInput();
    }
    
    public function readdata(){
        // Get all items from the list
        $orders = $this->redis->lrange("orders:BTCUSDT", 0, -1);
        print_r($orders);
        echo "<hr>";
        $filled = $this->redis->lrange("filled_orders:BTCUSDT", 0, -1);
        print_r($filled);
        
    }
    
    public function cleanredis(){
        $this->redis->flushdb();
    }

}