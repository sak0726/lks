<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public $ip;
    public function __construct()
	{
		parent::__construct();
		$this->load->database('t');
		$this->load->helper('url');
		//ipチェック
		$this->load->library('session');	

	}
	public function logout(){
		$this->load->library('session');
		
			$this->session->sess_destroy();
	
			header('location:../');
		
	}		

	public function index()
	{
		if(isset($_SESSION)){
			$this->session->sess_destroy();
		}
		$this->load->view('login');
		
	}

	public function login()
	{

		$name=$this->input->post('name');
		$pass=$_POST['pass'];
		$this->db->where('name',$name);
		$p=$this->db->get('users')->row('password');
		$this->load->model('Login');
		if(password_verify($pass,$p)){
			$this->Login->check($pass,$name);
		}else{
			$this->Login->checkno();		
		}
		
	}
	public function menu()
	{
		$this->load->view('menu');
	}
	public function kanri()
	{
		$this->load->model('Get_data');
		if(isset($_GET['num'])){
			$cust=$_GET['customer'];
			$year=$_GET['year'];
			$num=$_GET['num'];
			$k=$cust.$year."-".$num;

			$data['rs']=$this->Get_data->get_Fullkanri($k);
			$data['count']=$this->Get_data->get_Fullkc($k);
		}else{
			$data['rs']=$this->Get_data->get_kanri();
			$data['count']=$this->Get_data->get_rows();
		}
		$data['res']=$this->Get_data->get_custId();
		
		$this->load->model('Get_gai');
		$data['year']=$this->Get_gai->get_touroku_year();
		$this->load->view('kanri',$data);
	}
	public function yosan(){
		$this->load->model('Get_data');
		$data['rs']=$this->Get_data->get_yosan();
		//$data['count']=$this->Get_data->get_rows();

		$this->load->view('yosan',$data);
	}
	public function kanri_c()
	{
		$this->load->model('Get_data');
		$data['rs']=$this->Get_data->get_kanri_c();
		$data['res']=$this->Get_data->get_custId();
		$this->load->view('kanri',$data);

	}
	public function zuban_Up(){
		$this->load->model('Update');
		$this->Update->zuban();
	}
	public function hinmei_Up(){
		$this->load->model('Update');
		$this->Update->hinmei();
	}

	public function kanri_get()
	{
		$this->load->model('Get_data');
		$this->Get_data->get_meisai();

	}
	public function kanri_up()
	{
		$this->load->model('Update');

		if(isset($_GET['kt'])){
			$this->Update->kt();
		}else if(isset($_GET['tanka'])){
			$this->Update->kt_tanka();
		}else{
			$this->Update->kt_gai();
		}
	}
	public function bunseki(){
		if(isset($_GET['kanri_num'])){
			$this->load->model('Bunseki');
			$data['kanri']=$this->Bunseki->get_kanri();
			$this->load->view('bunseki_sub',$data);
			return;
		}
		if(isset($_GET['kikan'])){
			$this->load->model('Bunseki');
			$data['kanri']=$this->Bunseki->get_kikan();
			$this->load->view('bunseki_sub',$data);
			return;
		}
		$this->load->model('Bunseki');
		$this->load->model('Get_data');
		$data['cust']=$this->Get_data->cust();
		$data['list']=$this->Bunseki->get_data();

		$this->load->view('bunseki',$data);
	}
	public function koutei_get()
	{
		$this->load->model('Get_data');
		$this->Get_data->get_koutei();

	}
	function kt_up(){
		$this->load->model('Update');

		if(isset($_GET['koutei'])){
			$this->Update->kt_up();
		}else if(isset($_GET['fst_tantou'])){
			$this->Update->kt_up();
		}else{
			$this->load->model('Get_list');
			$this->Get_list->kt_up();
		}
	}
	function kt_ajax(){
		$this->load->model('Get_data');
		$data['res']=$this->Get_data->get_all_setting();
		$this->load->view('tabmenuktajax',$data);
	}
	public function z_up(){
		$this->load->model('Update');
		if(isset($_GET['mt'])){
			$this->Update->mt();
		}else if(isset($_GET['zstore'])){
			$this->Update->zs();
		}else if(isset($_GET['tanka'])){
			$this->Update->ztanka();
		}else if(isset($_GET['new'])){
			$this->Update->zai_new();
			$this->load->model('Get_data');
			$data['res']=$this->Get_data->get_all_setting();
			$this->load->view('tabmenuajax',$data);
			return;
		}else if(isset($_GET['buzai'])){
			$this->Update->b_up();
		}else{
			$this->Update->size();
		}
	}

	public function meisai_Update()
	{
		$this->load->model('Update');
		$this->Update->meisai_t();
	}
	public function m_up(){
		$this->load->model('Update');
		$this->Update->meisai_up();
	}

	public function meisai(){
		if(isset($_GET['move_num'])){
			$this->load->model('Jutyu');
			$this->Jutyu->move_num();
		}
	}

	public function mitsumori()
	{
		$this->load->model('Get_data');
		$data['list']=$this->Get_data->get_customer();
		$data['mat']= $this->Get_data->get_mat();
		$data['mg']=$this->Get_data->get_m_group();
		$data['kata']=$this->Get_data->get_m_kata();
		if(isset($_GET['id'])){
		$data['hist']= $this->Get_data->get_history();
		$data['hsub']= $this->Get_data->get_odsub();
		$data['count']= $this->Get_data->total_count();
		$data['t_price']= $this->Get_data->total_subprice();
		}
		$this->load->view('mitsumori',$data);
	}
	public function m_mitsu()
	{
		$this->load->model('Get_data');
		$data['list']=$this->Get_data->get_customer();

		$this->load->view('m_mitsu',$data);
	}
	public function mb()
	{
		$this->load->model('Get_data');
		$data['list']=$this->Get_data->get_customer();

		$this->load->view('mb',$data);
	}

	public function kanri_req(){
		$this->load->model('Update');
		$this->Update->req();
	}
	public function jutyu()
	{
		$this->load->model('Get_data');
		$data['tanis']=$this->Get_data->get_tani();

		if(isset($_GET['id'])){
			$data['hist']= $this->Get_data->get_history();//975
			$data['list']=$this->Get_data->get_customer();
			$data['mat']= $this->Get_data->get_mat();
			$data['zai']=$this->Get_data->get_z_history();
			$data['zgai']=$this->Get_data->get_zgai();
			$data['zaiko']=$this->Get_data->get_zaiko();
			$data['ke']=$this->Get_data->get_kt();
			$data['gai_all']=$this->Get_data->get_ktgai();
			$data['kt']=$this->Get_data->get_ktg();
			$this->load->view('jutyu_hist',$data);
			return;
		}elseif(isset($_GET['cul'])){
			$this->Get_data->cul();
			return;
		}elseif(isset($_GET['tan_upd'])){
			$this->load->model('Update');
			$this->Update->tan();
			return;
		}elseif(isset($_GET['numUp'])){
			$this->load->model('Update');
			$this->Update->number_update();
			$data['hist']=$this->Get_data->get_data();
			if(!isset($_GET['new'])){
				$this->load->view('jutyu_subhis',$data);
			}else{
				$this->load->view('jutyu_sub',$data);
			}
			return;
		}else{
			$data['list']=$this->Get_data->get_customer();
			$data['mat']= $this->Get_data->get_mat();
			$data['maxId']=$this->Get_data->get_FMaxId();
			$this->load->view('jutyu',$data);
		}
		
	}
	public function jutyu_head(){
		$this->load->model('Update');
		if(isset($_GET['day'])){
			$this->Update->head_up_del();
		}else{
			$this->Update->head_up();
		}
	}
	public function kotei(){
		$this->load->model('Update');
		$this->Update->up_kotei();
	}
	public function get_koutei(){
		$this->load->model('Get_data');
		$this->Get_data->get_kt_all();
	}
	public function kanri_close(){
		$this->load->model('Update');
		if(isset($_GET['hist'])){
			$this->Update->kanri_close();
		}
	}

	public function kanri_inst(){//受注
		if(isset($_GET['id'])){
			$this->load->model('Jutyu');
			$this->Jutyu->k_Up($_GET['id']);
		}else{
			$this->load->model('Jutyu');
			$this->Jutyu->kanri_Inst();
		}
		
	}
	public function tyu_Inst(){//履歴
		if(isset($_GET['id'])){
			$this->load->model('Update');
			$this->Update->k_Up($_GET['id']);
		}else{
			$this->load->model('Update');
			$this->Update->kanri_Inst();
		}
		
	}
	public function get_MaxId(){
		$this->load->model('Get_data');
		$this->Get_data->max_id();
	}
	public function koutei(){
		$this->load->model('Get_data');
		$data['res']=$this->Get_data->get_gaityu();
		$this->load->view('gaityulist',$data);
	}
	public function customer()
	{
		$this->load->model('Get_data');
		$this->load->model('Update');
		if(isset($_GET['new'])){
			$data['cat']=$this->Get_data->get_c_cat(0);
			$this->load->view('customer',$data);
			return;
		}elseif(isset($_GET['id'])){
			$data['list']=$this->Update->get_data($_GET['id']);
			$data['tantou']=$this->Get_data->get_tantou($_GET['id']);
			$data['cat']=$this->Get_data->get_c_cat(0);
			$this->load->view('customer',$data);
		}elseif(isset($_GET['aj'])){
			$data['res']=$this->Get_data->cust();
			$data['cat']=$this->Get_data->get_c_cat(0);
			$this->load->view('tabmenuajax_cust',$data);
			return;
		}elseif(isset($_GET['cat_delete'])){
			$data['cat']=$this->Update->cat_delete();
			$this->load->view('cust_catajax',$data);
			return;
		}elseif(isset($_GET['cat'])){
			$data['cat']=$this->Update->c_joken();
			$this->load->view('cust_catajax',$data);
			return;

		}elseif(isset($_GET['get_cat'])){
			$this->Get_data->get_c_cat(1);
			return;
		}else{
			$this->load->model('Get_data');
			$data['res']=$this->Get_data->cust();
			$this->load->view('customerlist',$data);
		}
	}
	public function get_data(){
		$this->load->model('Jutyu');
		$this->Jutyu->get_z();
	}
	public function get_mat(){
		$this->load->model('Get_data');
		$this->Get_data->get_z();
	}
	public function get_zairyo(){
		$this->load->model('Get_data');
		$this->Get_data->get_zairyo();
	}

	public function get_zai(){
		$this->load->model('Get_data');
		$this->Get_data->get_zairyoya();
	}
	public function gai()
	{
		if(isset($_GET['new'])){
			$this->load->model('Get_gai');
			$data['jouken']=$this->Get_gai->get_joken();
			$data['cat']=$this->Get_gai->get_cat();
			$this->load->view('gaityu',$data);
		}elseif(isset($_GET['id'])){
			$this->load->model('Get_gai');
			$data['list']=$this->Get_gai->get_Gdata();
			$data['cat']=$this->Get_gai->get_cat();
			$data['jouken']=$this->Get_gai->get_joken();
			$this->load->view('gaityu',$data);
		}elseif(isset($_GET['del'])){
			$this->load->model('Get_gai');
			$this->Get_gai->del($_GET['del']);

			$this->load->model('Get_data');
			$data['gai']=$this->Get_data->get_gai_cat();
			$this->load->view('tabmenuajax_gai',$data);//データ取得
		}else if(isset($_GET['hidden'])){
			$this->load->model('Get_gai');
			$this->Get_gai->shwhid();
		}else{
			$this->load->model('Get_data');
			$data['res']=$this->Get_data->get_gaityu();
			$this->load->view('gaityulist',$data);
		}
	}
	public function get_gaityu(){
		$this->load->model('Get_gai');
		$this->Get_gai->get_kt_gai();
	}
	public function gait(){
		$this->load->model('Get_data');
		$data['res']=$this->Get_data->get_all_setting();
		$this->load->view('tabmenu',$data);
	}
	public function ajaxgai(){
		$this->load->model('Get_data');
		$data['res']=$this->Get_data->get_all_setting();
		$this->load->view('tabmenuajax',$data);
	}
	public function ajaxcat(){
		$this->load->model('Get_data');
		$data['res']=$this->Get_data->get_all_setting();
		if(isset($_GET['kt'])){
			$this->load->view('tabmenuajaxktcat',$data);
			return;
		}else{
			$this->load->view('tabmenuajaxcat',$data);
			return;
		}	}
	public function gupdate()
	{
		$this->load->model('Update');
		if(isset($_GET['ckSymb'])){
			$this->Update->g_symb();
			return;
		}elseif(isset($_GET['cat'])){
			$this->Update->gai_cat();
		}
	}
	public function g_update(){
		$this->load->model('Update');
		$this->Update->gai_Up();
		$this->load->view('gaityu');
		return;
	}
	public function gai_update(){
		$this->load->model('Get_data');
		if(isset($_GET['new'])){
			$data['gai']=$this->Get_data->get_gai_cat();
			$this->load->view('tabmenuajax_gai',$data);//データ取得
		}
	}
	public function g_inst()
	{
		$this->load->model('Update');
		$this->Update->gai;
		$data['list']=$this->Update->gai();
		$this->load->view('gaityu',$data);
	}
	public function j_z_inst(){
		$this->load->model('Jutyu');
		$this->Jutyu->z_inst();
	}
	public function z_inst(){
		$this->load->model('Update');
		if(isset($_GET['new'])){
			$this->Update->z_inst_new();
		}else{
			$this->Update->z_inst();
		}
	}
	public function j_kj_inst(){
		$this->load->model('Jutyu');
		$this->Jutyu->kj_inst();

	}
	public function j_kj_del(){
		$this->load->model('Update');
		$this->Update->kj_del();
	}
	public function j_kt_inst(){
		$this->load->model('Jutyu');
		$this->Jutyu->kt_inst();
	}
	public function j_kt_tanka(){
		$this->load->model('Update');
		if(isset($_GET['meisai'])){
			$this->Update->kt_meisai_up();
		}else{
			$this->Update->kt_tanka_up();
		}
	}
	public function kt_inst(){
		$this->load->model('Update');
		$this->Update->kt_inst();
	}
	function meisai_Inst(){//受注
		$this->load->model('Jutyu');
		if(isset($_GET['delete'])){
			$this->Jutyu->kb_delete();
		}else{
			$this->Jutyu->m_inst();
		}
	}
	function nouhin_upd(){
		$this->load->model('Update');
		$this->Update->nouhin();
	}
	function inst_z(){//履歴
		$this->load->model('Update');
		if(isset($_GET['delete'])){
			$this->Update->kb_delete();
		}else if(isset($_GET['zikt'])){
			$this->Update->kb_del();
		}else{		
			$this->Update->inst();
		};
	}
	function j_top_insert(){
		$this->load->model('Jutyu');
		$this->Jutyu->top_insert();
	}
	function top_insert(){
		$this->load->model('Update');
		$this->Update->top_insert();
	}

	function j_k_delete(){
		$this->load->model('Jutyu');
		$this->Jutyu->k_delete();
	}

	function k_delete(){
		$this->load->model('Update');
		$this->Update->k_delete();
	}

	public function gaityu()
	{
		$this->load->view('gaityu');
	}
	public function gt(){
		$this->load->model('Get_gai');
		$this->Get_gai->w();
	}

	public function gai_kanri()//Get_gai 32
	{
		$this->load->model('Get_gai');
		if(isset($_GET['date_upd'])){
			$this->Get_gai->d_upd();
			return;
		}
		if(isset($_GET['ck'])){
			$this->Get_gai->ck();
			return;
		}
		if(isset($_GET['hatyu_cnt'])){
			return $this->Get_gai->hatyu_cnt();
		}
		if(isset($_GET['tw'])){
			$this->Get_gai->tb_upd();
			return;
		}
		if(isset($_GET['off'])){
			$this->Get_gai->ck_off();
			return;
		}

		$data['koutei']=$this->Get_gai->get_koutei();
		$data['gai_cat']=$this->Get_gai->gai();
		$data['year']=$this->Get_gai->get_year();//年

		if(isset($_GET['p'])){
			$data['cnt']=$this->Get_gai->fil_count();
			$data['total']=$this->Get_gai->total();
			$data['gaims']=$this->Get_gai->html_data();
			$this->load->view('gai_kanri_tb',$data);
			return;
		}elseif(isset($_GET['hatyu_data'])){
			$data['gaims']=$this->Get_gai->hatyu_data();
			$data['total']=$this->Get_gai->hatyu_total();
			$this->load->view('gai_kanri_tb',$data);
			return;
		}else{
			$data['total']=$this->Get_gai->fst_total();
			$data['cnt']=$this->Get_gai->fil_count();
			$data['year']=$this->Get_gai->get_year();//年
			$data['gaims']=$this->Get_gai->fil_g();//発注データ
			$this->load->view('gai_kanri',$data);
		}
		
	}


	public function zai_kanri()
	{
		$this->load->model('Get_zai');
		$data['z_st']=$this->Get_zai->get_z_store();//全仕入先
		$data['z_cat']=$this->Get_zai->zai();//全材質データ
		$data['year']=$this->Get_zai->get_year();//年531

		if(isset($_GET['search'])){
			$data['cnt']=$this->Get_zai->scount();//行数カウント
			$data['zaims']=$this->Get_zai->s_data();//発注データ
			$this->load->view('zai_kanri_tb',$data);
			return;
		}elseif(isset($_GET['tehai'])){
			$data['cnt']=$this->Get_zai->tehai_total();//合計金額
			$data['zaims']=$this->Get_zai->mitehai();
			$this->load->view('zai_kanri_tb',$data);
			return;
		}elseif(isset($_GET['minou'])){
			$data['cnt']=$this->Get_zai->minou_total();//合計金額
			$data['zaims']=$this->Get_zai->minou();
			$this->load->view('zai_kanri_tb',$data);
			return;
		}elseif(isset($_GET['nouhin'])){
			$data['cnt']=$this->Get_zai->nou_total();//合計金額
			$data['zaims']=$this->Get_zai->nou();
			$this->load->view('zai_kanri_tb',$data);
			return;
		}elseif(isset($_GET['hdate'])){
			$data['zaims']=$this->Get_zai->hdate();
			$data['cnt']=$this->Get_zai->hcnt();
			$this->load->view('zai_kanri_tb',$data);
			return;
		}elseif(isset($_GET['ndate'])){
			$data['zaims']=$this->Get_zai->ndate();
			$data['cnt']=$this->Get_zai->ncnt();
			$this->load->view('zai_kanri_tb',$data);
			return;
		}elseif(isset($_GET['p'])){
			$data['cnt']=$this->Get_zai->fil_count();//行数カウント
			$data['zaims']=$this->Get_zai->fil_z();//発注データ
			$this->load->view('zai_kanri_tb',$data);
			return;
		}else{
			$data['cnt']=$this->Get_zai->fil_count();//行数カウント 125
			$data['zaims']=$this->Get_zai->fil_data();//発注データ 209
			$this->load->view('zai_kanri',$data);
			return;
	}

		//$this->load->view('zai_kanri',$data);
	}
	public function zai_tw(){
		$this->load->model('Get_zai');
		$this->Get_zai->tw_write();
	}
	public function z_upd()
	{
		$this->load->model('Get_zai');
		if(isset($_GET['ck'])){
			$this->Get_zai->z_ck();
		}else if(isset($_GET['hiduke'])){
			$this->Get_zai->hatyu_D();
		}else{
			$this->Get_zai->z_kanri();
		}
	}
	public function ajxzai(){
		$this->load->view('ajxzai');
	}
	public function zai(){
		$this->load->model('Get_zai');
		$data['cnt']=$this->Get_zai->hatyu();

	}
	public function mat_upd(){
		$this->load->model('Get_zai');
		$this->Get_zai->mat_up();
	}
	public function cat_upd(){
		if(isset($_GET['kt'])){
			$this->load->model('Get_gai');
			$this->Get_gai->cat_up();
		}else if(isset($_GET['kt_delete'])){
			$this->load->model('Update');
			$this->Update->kt_cat_del();
		}else if(isset($_GET['delete'])){
			$this->load->model('Update');
			$this->Update->bz_del();
		}else{
			$this->load->model('Get_zai');
			$this->Get_zai->cat_up();
		}
	}
	public function gai_kanri_search()//Get_gai 268
	{
		$this->load->model('Get_gai');
		$data['koutei']=$this->Get_gai->get_koutei();
		$data['cnt']=$this->Get_gai->s_count();//件数
		$data['year']=$this->Get_gai->get_year();//年
		$data['gai_cat']=$this->Get_gai->s_gai();//外注一覧
		$data['gaims']=$this->Get_gai->s_g();//発注データ
		
		$this->load->view('gai_kanri',$data);
	}
	public function g_upd(){
		$this->load->model('Get_gai');
		if(isset($_GET['ck'])){
			$this->Get_gai->upck();
		}else if(isset($_GET['hiduke'])){
			$this->Get_gai->hd();
		}else{
			$this->Get_gai->gh_upd();
		}
	}
	public function submenu()
	{
		$this->load->view('submenu');
	}
	public function update()
	{
		$this->load->model('Update');
		$this->Update->customer();
		$this->load->view('submenu');
		
	}
	public function k(){
		$this->load->model('Get_data');
		$this->Get_data->chg();
	}

	public function custupdate()
	{
		$this->load->model('Update');
		$this->load->model('Get_data');
		$c_id=$this->Update->do_update();

		$data['list']=$this->Update->get_data($c_id);
		$data['tantou']=$this->Get_data->get_tantou($c_id);
		$data['cat']=$this->Get_data->get_c_cat(0);
		$this->load->view('customer',$data);
	}
	public function cust_del()
	{
		$this->load->model('Update');
		$this->Update->cust_delete();

		$this->load->model('Get_data');
		$data['res']=$this->Get_data->cust();
		$data['cat']=$this->Get_data->get_c_cat(0);
		$this->load->view('tabmenuajax_cust',$data);
		return;

	}
	public function jisya()
	{
		$this->load->model('Update');
		$data['list']=$this->Update->get_jisya();
		$this->load->view('own',$data);
	}

	public function jupdate()
	{
		$this->load->model('Update');
		$data['list']=$this->Update->jisya();
		$this->load->view('own',$data);
	}
	public function user_update(){
		$this->load->model('Update');
		$this->Update->user();
	}

	public function mat_up()
	{
		$this->load->model('Material');
		$this->Material->dataup();
	}
	public function m_update()
	{
		$this->load->model('Material');
		$data['list']=$this->Material->m_update();
		$this->load->view('mat_list',$data);
	}
	public function get_material()
	{
		if(!isset($_GET['thickness'])){
			$this->load->model('Material');
			$this->Material->get_mat();
		}else{
			$this->load->model('Material');
			$this->Material->thick();
		}
	}
	public function get_kakoup()
	{
		$this->load->model('Frice');
		$this->Frice->frice_kakou();
	}
	public function set_material()
	{
		if(isset($_GET['aex'])){
			$this->load->model('Material');
			$this->Material->aex();
		}else{
			$this->load->model('Material');
			$this->Material->setGrav();
		}
	}

	public function oder()
	{
		$this->load->model('Oder');
		if (isset($_GET['new'])){
			$this->Oder->oder_enter();
		}elseif(isset($_GET['count'])){
			$this->Oder->oder_count();
		}elseif(isset($_GET['head'])){
			$this->Oder->oder_head();
		}elseif(isset($_GET['kakou'])){
			$this->Oder->oder_kakouUp();
		}elseif(isset($_GET['k_new'])){
			$this->Oder->oder_kakouNew();
		}elseif(isset($_GET['upd'])){
			$this->Oder->oder_upd();
		}else{
			$this->Oder->oder_Update();
		}
	}


	public function get_cust()
	{
		$this->load->model('Get_data');
		$this->Get_data->get_custid();
	}


	public function kazu_up()
	{
		$this->load->model('Material');
		$this->Material->kazu_up();

	}
	public function kazu_ex()
	{
		$this->load->model('Material');
		$this->Material->kazu_ex();

	}

	public function print()
	{
		$this->load->model('Get_data');
		$data['jisya']=$this->Get_data->jisya();//共通

		if($_GET['cat']==='m' || $_GET['cat']==='n'){
			$data['main']=$this->Get_data->get_pmain();
			$data['kei']=$this->Get_data->total_price();
			$data['count']=$this->Get_data->total_count();
			if ($_GET['cat']==='m'){
				$this->load->view('rp_mitsumori',$data);
			}else if($_GET['cat']==='n'){
				$this->load->view('rp_nouhin_sk',$data);
			}
		}

		if($_GET['cat']==='h'){
			$this->load->view('rp_hatyukmall',$data);
		}
		if($_GET['cat']==='kanri'){
			$this->load->model('Get_denpyo');
			$data['main']=$this->Get_denpyo->get_pmain();
			$data['kei']=$this->Get_denpyo->get_price();
			$data['count']=$this->Get_denpyo->get_pcount();
			$this->load->view('rp_kanri',$data);

		}
		if($_GET['cat']==='genpin'){
			$data['main']=$this->Get_data->get_pgenpin();
			$data['od_head']=$this->Get_data->get_p_odhead();
			$this->load->view('rp_genpin',$data);
		}
		if($_GET['cat']==='zai'){
			$this->load->view('rp_zairyoukm',$data);
		}
		if($_GET['cat']==='zaim'){
			$this->load->view('rp_zairyoum',$data);
		}
		if($_GET['cat']==='aimitsu'){
			$this->load->model('Get_zai');
			$data['store']=$this->Get_zai->ai();
			$this->load->view('rp_zaiai',$data);
		}
		if($_GET['cat']==='ai'){
			$this->load->model('Get_zai');
			//$data['store']=$this->Get_zai->aim();
			$this->load->view('rp_zaiai',$data);
		}if($_GET['cat']==='karam'){
			$this->load->view('rp_zkaram',$data);
		}
		if($_GET['cat']==='seikyu_kb'){
			$data['main']=$this->Get_data->get_pmain();
			$data['kei']=$this->Get_data->total_price();
			$data['count']=$this->Get_data->total_count();

			$this->load->view('rp_seikyu',$data);
		}
		if($_GET['cat']==='seikyu_all'){
			$this->load->view('rp_seikyu_all',$data);
		}
		if($_GET['cat']==='zkomi'){
			$data['main']=$this->Get_data->get_pmain();
			$data['kei']=$this->Get_data->total_price();
			$data['count']=$this->Get_data->total_count();
			$this->load->view('rp_seikyu',$data);
		}
		if($_GET['cat']==='znuki'){
			$data['main']=$this->Get_data->get_pmain();
			$data['kei']=$this->Get_data->total_price();
			$data['count']=$this->Get_data->total_count();
			$this->load->view('rp_seikyunuki',$data);
		}

	}

	public function history()
	{
		$this->load->model('Oder');
		$data['res']=$this->Oder->history();
		$data['cnt']=$this->Oder->count();
		$this->load->view('od_history',$data);

	}
	public function thick()
	{
		$this->load->model('Thick');
		if(isset($_GET['add'])){
			$this->Thick->add_a();
		}
		if(isset($_GET['update'])){
			$this->Thick->up_a();
		}
		if(isset($_GET['updateba'])){
			$this->Thick->up_ba();
		}
		if(isset($_GET['updateb'])){
			$this->Thick->up_b();
		}
		if(isset($_GET['tg'])){
			$this->Thick->add_tg();
		}
		if(isset($_GET['tgf'])){
			$this->Thick->add_tgf();
		}
		if(isset($_GET['tgh'])){
			$this->Thick->add_tgh();
		}
		if(isset($_GET['del'])){
			$this->Thick->del();
		}
		if(isset($_GET['delb'])){
			$this->Thick->del_haba();
		}
		if(isset($_GET['haba'])){
			$this->Thick->add_haba();
		}
		//H鋼
		if(isset($_GET['hkou'])){
			$this->Thick->add_h();
		}
		if(isset($_GET['delh'])){
			$this->Thick->del_h();
		}
		if(isset($_GET['upha'])){
			$this->Thick->up_ha();
		}
		if(isset($_GET['uphb'])){
			$this->Thick->up_hb();
		}
		if(isset($_GET['upht'])){
			$this->Thick->up_ht();
		}
		if(isset($_GET['uphtt'])){
			$this->Thick->up_htt();
		}
		if(isset($_GET['uphr'])){
			$this->Thick->up_hr();
		}
		$data['res']=$this->Thick->get_name();
		$data['thick']=$this->Thick->get_val();
		$data['thickb']=$this->Thick->get_valb();
		$data['thickh']=$this->Thick->get_valh();
		$this->load->view('thick',$data);
	}
	public function thickdel()
	{
		$this->load->model('Thick');
		$this->Thick->tdel();
	}
	public function thickCopy()
	{
		$this->load->model('Thick');
		$this->Thick->t_copy();
	}
	public function zaisyu()
	{
		$this->load->model('Material');
			if (isset($_GET['update'])){
				$this->Material->zsyu_update();
			}else if(isset($_GET['add'])){
				$this->Material->zsyu_add();
			}else if(isset($_GET['del'])){
				$this->Material->zsyu_del();
			}
	}

	public function zaisyu_kata()
	{
		$this->load->model('Material');
			if(isset($_GET['add'])){
				$this->Material->kata_add();
			}elseif(isset($_GET['update'])){
				$this->Material->kata_up();
			}elseif(isset($_GET['delete'])){
				$this->Material->kata_delete();
			}
	}

	public function kikaku()
	{
		$this->load->model('Thick');
		if(isset($_GET['add'])){
			$this->Thick->kikaku_add();
		}elseif(isset($_GET['addh'])){
			$this->Thick->kikaku_addh();
		}elseif(isset($_GET['get_b'])){
			$this->Thick->get_b();
		}else{
			$this->Thick->kikaku();
		}
	}

	public function get_kikaku()
	{
		$this->load->model('Thick');
		if(isset($_GET['pm'])){
			$this->Thick->get_pm();
		}else{
			$this->Thick->get_No();
		}
	}

	public function get_h(){
		$this->load->model('Thick');
		$this->Thick->get_h();
	}
	
	public function ex()
	{	
		if(isset($_POST['id'])){
			$this->load->model('Exx');
			$this->Exx->save();
		}
		$this->load->view('ex');
		
	
	}
	public function sv_mitsumori_clear()
	{	
			$this->load->model('Exx');
			$this->Exx->clear();
		
		$this->load->view('sv_mitsumori');
	}


	public function cook()
	{
		$this->load->helper('cookie');
		delete_cookie('user_id');
		$this->load->library('session');
		$this->session->sess_destroy();
		$this->load->view('login');
	}

	public function get_f_price()
	{
		$this->load->model('Frice');
		$this->Frice->get_fp();
	}
	public function gp_price()
	{
		$this->load->model('Update');
		$this->Update->get_gp();
	}

	public function jutyu_ajax_cat(){
		$this->load->model('Get_data');
		$data['cat']=$this->Get_data->get_cat_mat();
		$this->load->view('jutyu_ajax_cat',$data);
	}

	public function seikyu_form(){
		$this->load->model('Seikyu');
		if(isset($_GET['get'])){
			$data['data']=$this->Seikyu->get_ym();
			$this->load->view('seikyu_sub',$data);
			return;
		}
		if(isset($_GET['getk'])){
			$data['data']=$this->Seikyu->get_ymkai();
			$this->load->view('seikyu_subkai',$data);
			return;
		}
		if(isset($_GET['kake'])){
			$this->Seikyu->kaisyu();
			return;
		}
		if(isset($_GET['uri'])){
			$this->Seikyu->uri();
			return;
		}
		if(isset($_GET['rireki'])){
			$data['hist']=$this->Seikyu->rireki();
			$this->load->view('seikyu_sub_table',$data);
			return;
		}
		if(isset($_GET['rireki_del'])){
			$this->Seikyu->uri_del();
			return;
		}
		if(isset($_GET['delete'])){
			$this->Seikyu->rireki_delete();
			return;
		}
		if(isset($_GET['get_gaku'])){
			$this->Seikyu->get_zengetu();
			return;
			
		}
		$data['list']=$this->Seikyu->get_data();
		$this->load->view('seikyu',$data);
	}

	public function resheet(){
		$this->load->view('resheet');
	}

	public function m_top(){
		if(isset($_GET['top'])){
			$this->load->view('mobile_top');
		}else if(isset($_GET['sell'])){
			$this->load->model('Mobile');
			$data['items']=$this->Mobile->get_items();
			$this->load->view('mobile_sell',$data);
		}
	}

}

?>