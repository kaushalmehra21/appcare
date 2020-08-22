<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Order Pages & Queries */
class Career extends CI_Controller
{

    /** application Status Values
     *
     * @var array */
    protected $application = [
        '0' => 'new',
        '1' => 'approved',
        '2' => 'accept',
        '3' => 'reject',
        '4' => 'offered',
        '5' => 'hired'
    ];

    /** Delivery Status Values
     *
     * @var array */
    /* protected $Delivery = [
        '0' => 'new',
        '1' => 'delivered',
        '2' => 'in process',
        '3' => 'cancel',
        '4' => 'return'
    ]; */

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        flash_message(
            'dashboard/login',
            is_login(),
            'unsuccess',
            'Please Login Then Try Again'
        );

        $this->load->helper('string');
        $this->load->model([
            'CareerModel',
            'UsersModel'
        ]);
    }

    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }

    /** Add application */
    // public function add_application()
    // {
    //     flash_message(
    //         'dashboard/login',
    //         is_login(),
    //         'unsuccess',
    //         'Please Login Then Try Again'
    //     );

    //     user_can('add_application') or show_404();

    //     if ($this->input->post('apply')) {

    //         flash_message(
    //             'add/career',
    //             $this->input->post('name'),
    //             is_array($this->input->post('email'))
    //                 and $this->input->post('mobile')
    //                 and $this->input->post('experience')
    //                 and $this->input->post('qualification'),
    //             'unsuccess',
    //             'Something Went Wrong',
    //             'Look like Form Not Fill Properly, Please Fill & Try Again.'
    //         );
    //         // is($_POST['product'], 'array')
    //         //     and $products = $this->input->post('product');

    //         // $order_group_id = random_string('nozero', 8);
    //         // $last = $this->OrdersModel->first(['order_group_id' => 'ODR' . $order_group_id]);
    //         // is($last, 'array') and $order_group_id = random_string('nozero', 8);

    //         // if (is($products, 'array'))
    //         //     foreach ($products as $value) {
    //         //         $product = json_decode(json_encode($this->ProductsModel->first([
    //         //             'conditions' => [
    //         //                 'id'        => $value,
    //         //                 'post_type' => 'product'
    //         //             ],
    //         //             'fields' => ['id', 'sell_price']
    //         //         ])));

    //         //         $price      = (int) $product->sell_price;
    //         //         $product_id = $product->id;

    //         //         $this->agent->is_mobile()   and $device_type = 'mobile';
    //         //         $this->agent->is_browser()  and $device_type = 'web';


    //                 $application = $this->CareerModel->save([
    //                     'fullname'   => $this->input->post('fullname'),
    //                     'mobile'          => $this->input->post('mobile'),
    //                     'email'       => $this->input->post('email'),
    //                     'job_id' => $this->input->post('job_id'),
    //                     'experience'     => $this->input->post('experience'),
    //                     'qualification'       => $this->input->post('qualification'),
    //                     'message'           => $this->input->post('message'),
    //                     'status'           => '0',
    //                     'created_by'       => $_SESSION['USER_ID'],
    //                     'modified_by'      => $_SESSION['USER_ID'],
    //                 ]);
    //             }


    //     }

    //     $products = $this->ProductsModel->all([
    //         'feilds'     => ['id', 'title'],
    //         'conditions' => [
    //             'status!='  => 3,
    //             'post_type' => 'product'
    //         ],
    //         'datatype' => 'json'
    //     ]);



    //     $this->load->view('template/header');
    //     $this->load->view('template/sidebar');
    //     $this->load->view('order/add', compact('products', 'users'));
    //     $this->load->view('template/footer');
    // }


    /** Load application(career) List Page */
    public function list_application()
    {

        // user_can('list_applications') or show_404();
        /* $applicationData = json_decode(json_encode([
            'status' => '0'
        ])); */
        $applications = $this->CareerModel->all([
            'fields'     => ['id', 'resume', 'name', 'email', 'mobile', 'job_id', 'experience', 'qualification', 'message', 'created_date', 'status'],
            'conditions' => ['status'  => 0],
            'datatype' => 'json'
            // 'join'       => [
            //     'tableName' => 'applications',
            //     'condition' => 'applications.job_id = jobs.id'
            // ],
            // 'order'      => [
            //     'by'   => 'orders.id',
            //     'type' => 'DESC'
            // ],
            // 
        ]);
        /*  echo '<pre>';
        print_r($applications);
        die(); */

        // echo $this->db->last_query();
        // die();

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('career/list', compact('applications'));
        $this->load->view('template/footer');
    }
    /**  end of list application */

    /** Edit Order */
    public function edit_order($order_no)
    {
        empty($order_no) and show_404();

        flash_message(
            'dashboard/login',
            is_login(),
            'unsuccess',
            'Please Login Then Try Again'
        );

        user_can('order_edit') or show_404();

        if ($this->input->post('editOrder')) {

            flash_message(
                'edit/order/' . $order_no,
                $this->input->post('product'),
                is_array($this->input->post('product'))
                    and $this->input->post('user')
                    and $this->input->post('paymentMode')
                    and $this->input->post('paymentStatus')
                    and $this->input->post('status')
                    and $this->input->post('remark'),
                'unsuccess',
                'Something Went Wrong',
                'Look like Form Not Fill Properly, Please Fill & Try Again.'
            );
            is($_POST['product'], 'array')
                and $products = $this->input->post('product');

            $order_group_id = $order_no;

            if (is($products, 'array'))
                foreach ($products as $value) {
                    $product = json_decode(json_encode($this->ProductsModel->first([
                        'conditions' => [
                            'id'        => $value,
                            'post_type' => 'product'
                        ],
                        'fields' => ['id', 'sell_price']
                    ])));

                    $price      = (int) $product->sell_price;
                    $product_id = $product->id;

                    $this->agent->is_mobile()   and $device_type = 'mobile';
                    $this->agent->is_browser()  and $device_type = 'web';
                    !$this->agent->is_browser() and !$this->agent->is_mobile() and $device_type = 'rest';

                    $this->OrdersModel->destroy(['order_group_id' => $order_no]);

                    $order_id = $this->OrdersModel->save([
                        'order_group_id'   => $order_group_id,
                        'user_id'          => str_clean($this->input->post('user')),
                        'product_id'       => $product_id,
                        'product_quantity' => '1',
                        'total_amount'     => $price,
                        'total_paid'       => $price,
                        'remark'           => str_clean($this->input->post('remark'), [' ', ', ', '-', '_', '.', "'"]),
                        'payment_mode'     => str_clean($this->input->post('paymentMode')),
                        'payment_status'   => $this->input->post('paymentStatus'),
                        'delivery_status'  => $this->input->post('status'),
                        'status'           => true,
                        'transaction_id'   => random_string('md5', 20),
                        'transaction_msg'  => 'backend',
                        'user_ip'          => $this->input->ip_address(),
                        'browser'          => $this->agent->browser(),
                        'browser_version'  => $this->agent->version(),
                        'device_type'      => $device_type,
                        'os'               => $this->agent->platform(),
                        'mobile_device'    => $this->agent->mobile(),
                        'created_by'       => $_SESSION['USER_ID'],
                        'modified_by'      => $_SESSION['USER_ID'],
                    ]);
                }

            flash_message(
                'list/orders',
                $order_id,
                'unsuccess',
                'Something Went Wrong'
            );

            flash_message(
                'list/orders',
                $order_id,
                'success',
                'Order Added Successfully'
            );
        }

        $orders = $this->OrdersModel->all([
            'conditions' => [
                'status!='       => '3',
                'order_group_id' => $order_no
            ],
            'datatype' => 'json'
        ]);

        $products = $this->ProductsModel->all([
            'feilds'     => ['id', 'title'],
            'conditions' => [
                'status!='  => 3,
                'post_type' => 'product'
            ],
            'datatype' => 'json'
        ]);

        $users = $this->UsersModel->all([
            'feilds'     => ['id', 'first_name', 'last_name'],
            'conditions' => [
                'status'    => true,
                'user_type' => 'SUBSCRIBER'
            ],
            'datatype' => 'json'
        ]);

        $payments = $this->Payment;
        $delivery = $this->Delivery;

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('order/edit', compact('orders', 'products', 'users', 'payments', 'delivery'));
        $this->load->view('template/footer');
    }


    /** Delete Order */
    public function change_status($id)
    {
        // empty()and show_404();

        flash_message(
            'dashboard/login',
            is_login(),
            'unsuccess',
            'Please Login Then Try Again'
        );

        // user_can('change_status') or show_404();
        $appeal = $this->CareerModel->updateTable([
            'status' => '1',
        ], ['id' => $id]);
        flash_message(
            'list/career',
            $appeal,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/career',
            $appeal,
            'success',
            "Application Status Changed to Approved"
        );
    }
}

    /* End of file  Order.php */
