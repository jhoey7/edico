<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);

class Newtable {

	protected $CI;
	var $rows				= array();
	var $columns			= array();
	var $hiderows			= array();
	var $keys				= array();
	var $proses				= array();
	var $keycari			= array();
	var $heading			= array();
	var $column				= array();
	var $auto_heading		= TRUE;
	var $show_chk			= TRUE;
	var $show_menu  		= TRUE;
	var $show_no			= TRUE;
	var $caption			= NULL;	
	var $template 			= NULL;
	var $newline			= "\n";
	var $empty_cells		= "";
	var $actions			= "";
	var $detils				= "";
	var $td_click			= "";
	var $baris				= "AUTO";
	var $db 				= "";
	var $hal 				= "AUTO";
	var $uri				= "";
	var $show_search		= TRUE;
	var $orderby			= 1;
	var $sortby				= "ASC";
	var $formid				= "tb_form";
	var $divid				= "div_id";
	var $row_process		= "";
	var $indexField			= "";
	var $formField			= "";
	var $get_where			= "";
	var $tipe_proses		= "";
	var $check		        = "checkbox";
	var $show_paging		= TRUE;
	var $breadcrumbs 		= array();
	var $multiple_search 	= "";
	var $tmpchk				= "";
	var $show_column		= FALSE;
	var $header_bg			= "";
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->hiderows[] = 'HAL';
	}

	function header_bg($color)
	{
		$this->header_bg = 'background:'.$color;
		return;
	}
	
	function show_column($show)
	{
		$this->show_column = $show;
		return;
	}
	
	function page($page){
		$this->page = $page;
		return;
	}
	
	function multiple_search($show)
	{
		$this->multiple_search = $show;
		return;
	}
	
	function show_search($show)
	{
		$this->show_search = $show;
		return;
	}
	
	function show_paging($show)
	{
		$this->show_paging = $show;
		return;
	}
	
	function checked_val($checked)
	{
		$this->checked_val = $checked;
		return;
	}
	
	function show_chk($show)
	{
		$this->show_chk = $show;
		return;
	}
	
	function show_menu($show)
	{
		$this->show_menu = $show;
		return;
	}
	
	function tipe_proses($show)
	{
		$this->tipe_proses = $show;
		return;
	}
	
	function show_no($show)
	{
		$this->show_no = $show;
		return;
	}
	
	function columns($col)
	{
		$this->columns = $col;
		return;
	}
	
	function orderby($order)
	{
		$this->orderby = $order;
		return;
	}
	
	function sortby($sort)
	{
		$this->sortby = $sort;
		return;
	}
	
	function groupby($group)
	{
		$this->groupby = $group;
		return;
	}
	
	function topage($to)
	{
		$this->hal = (int)$to;
		return;
	}
	
	function cidb($db)
	{
		$this->db = $db;
		return;
	}
	
	function rowcount($row)
	{
		$this->baris = $row;
		return;
	}
	
	function ciuri($post)
	{
		$this->ciuri = $post;
		return;
	}
	
	function action($act)
	{
		$this->actions = $act;
		return;
	}
	
	function detail($act)
	{
		$this->detail = $act;
		return;
	}
	
	function formField($act)
	{
		$this->formField = $act;
		return;
	}
		
	function indexField($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if( ! in_array($a, $this->indexField)) $this->indexField[] = $a;
		}
		return;
	}
		
	function hiddens($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if( ! in_array($a, $this->hiderows)) $this->hiderows[] = $a;
		}
		return;
	}
	
	function keys($row)
	{
		$this->keys = array();
		if(!is_array($row)){
			$row = array($row);
		}
		foreach($row as $a){
			if(!in_array($a, $this->keys)) 
				$this->keys[] = $a;
		}
		return;
	}
	
	function validasi($row)
	{
		$this->validasi = array();
		if(!is_array($row)){
			$row = array($row);
		}
		foreach($row as $a){
			if(!in_array($a, $this->validasi)) 
				$this->validasi[] = $a;
		}
		return;
	}
	
	function checked($row)
	{
		$this->checked = array();
		if(!is_array($row)){
			$row = array($row);
		}
		foreach($row as $a){
			if(!in_array($a, $this->checked)) 
				$this->checked[] = $a;
		}
		return;
	}
	
	function group($row)
	{
		if ( ! is_array($row))
		{
			$row = array($row);
		}
		foreach ( $row as $a )
		{
			if( ! in_array($a, $this->group)) $this->group[] = $a;
		}
		return;
	}
	
	function menu($row)
	{
		if ( ! is_array($row))
		{
			return FALSE;
		}
		$this->proses = $row;
		return;
	}
	
	function search($row)
	{
		if ( ! is_array($row))
		{
			return FALSE;
		}
		$this->keycari = $row;
		return;
	}
	
	function tipe_check($type)
	{
		if($type=="radio"){
			$this->check = "radio";
		}else{
			$this->check = "checkbox";	
		}
		return;
	}
	
	function set_template($template)
	{
		if ( ! is_array($template)) return FALSE;
		$this->template = $template;
	}
	
	function set_heading()
	{
		$args = func_get_args();
		$this->heading = (is_array($args[0])) ? $args[0] : $args;
	}
	
	function make_columns($array = array(), $col_limit = 0)
	{
		if ( ! is_array($array) OR count($array) == 0) return FALSE;
		$this->auto_heading = FALSE;
		if ($col_limit == 0) return $array;
		$new = array();
		while(count($array) > 0)
		{	
			$temp = array_splice($array, 0, $col_limit);
			if (count($temp) < $col_limit)
			{
				for ($i = count($temp); $i < $col_limit; $i++)
				{
					$temp[] = '&nbsp;';
				}
			}
			$new[] = $temp;
		}
		return $new;
	}

	function set_empty($value)
	{
		$this->empty_cells = $value;
	}
	
	function add_row()
	{
		$args = func_get_args();
		$this->rows[] = (is_array($args[0])) ? $args[0] : $args;
	}

	function set_caption($caption)
	{
		$this->caption = $caption;
	}	
	
	function set_formid($formid)
	{
		if($formid)
			$this->formid = $formid;
		else
			$this->formid = 'tb_form';		
	}	
	
	function set_divid($divid)
	{
		if($divid)
			$this->divid = $divid;
		else
			$this->divid = 'div_id';		
	}
	
	function set_column($row)
	{
		if ( ! is_array($row))
		{
			return FALSE;
		}
		$this->column = $row;
		return;
	}
	
	function generate($table_data = NULL){	
		$ENCRIPT =& get_instance();
		$ENCRIPT->load->library('azdgcrypt');
		if ( ! is_null($table_data))
		{
			if (is_object($table_data)){
				$this->_set_from_object($table_data);
			}
			elseif (is_array($table_data)){
				$set_heading = (count($this->heading) == 0 AND $this->auto_heading == FALSE) ? FALSE : TRUE;
				$this->_set_from_array($table_data, $set_heading);
			}
			elseif ($table_data!=""){
				if(!is_array($this->ciuri)){
					$this->ciuri = explode("|",$this->ciuri);					
				}
				if ($this->db == "" || !is_array($this->ciuri)) return 'Missing required params';
				$toggle = $this->CI->input->post('toggle'.$this->formid);
				if(!$toggle) $display = "display:none";
				else $checked = "checked";
				$tercari = "";
				$arrvalcari = array();
				if($keys = $this->CI->input->post('form')){
					$where = strpos(strtolower($table_data), "where");
					if($where === false) $tercari = " WHERE 1=1";
					if($this->multiple_search){
						foreach($keys as $a => $b){
							$cari = $b;
							$arrvalcari[] = $b;
							$arrelement = $this->keycari[$a];
							$field = $arrelement[0];
							$type = $arrelement[2];
							if($type=="DATERANGE"){
								if(count($cari) > 0){
									$start = $cari[0];
									$end = $cari[1];
									if(($start!="")&&($end!="")){
										$tercari .= " AND DATE($field) BETWEEN '".validate($start,'DATE')."' AND '".validate($end,'DATE')."'";
									}else if($start!=""){
										$tercari .= " AND DATE($field) >= '".validate($start,'DATE')."'";
									}else if($end!=""){
										$tercari .= " AND DATE($field) <= '".validate($end,'DATE')."'";
									}
								}
							}else{
								if($cari[0]!=""){
									$tercari .= " AND $field LIKE '%$cari[0]%'";
								}	
							}
						}
					}else{
						foreach($keys as $a => $b){
							$arrvalcari[] = $b;
							$arrelement = $this->keycari[$arrvalcari[0]];
							$field = $arrelement[0];
							$type = $arrelement[2];
							if($arrvalcari[1]!=""){
								$tercari .= " AND $field LIKE '%$arrvalcari[1]%'";
							}
						}
					}
					$table_data .= $tercari;
				}
				if ($this->baris == "AUTO"){
					if($key = array_search('row', $this->ciuri)) $this->baris = (int)$this->ciuri[$key+1];
					if($this->baris < 1) $this->baris = 10;
				}
				if ( $this->baris != "ALL"){
					if($this->baris > 100) $this->baris = 100;
				}
				if($this->CI->input->post('limit')) $this->baris = (int)$this->CI->input->post('limit');
				if(array_filter($this->groupby)){
					$table_data .= " GROUP BY";
					foreach($this->groupby as $group){
						$val_group .= " $group,";
					}
					$table_data .= substr(" $val_group",0,-1);
				}
				$total_record = 0;
				$table_count = $this->db->query("SELECT COUNT(1) AS JML FROM ($table_data) AS TBL");
				if($table_count){
					$table_count = $table_count->row();
					$total_record = $table_count = $table_count->JML;
				}else{
					$total_record = 0;
				}
				
				if ($this->baris != "ALL"){
					$table_count = ceil($table_count / $this->baris);
					if ( $this->hal == "AUTO") if($this->CI->input->post('page')) $this->hal = (int)$this->CI->input->post('page');
					if ( $this->hal < 1) $this->hal = 1;
					if ( $this->hal > $table_count) $this->hal = $table_count;
					if ( $this->hal<=1){
						$dari = 0;
						$sampai = $this->baris;
					}
					else{
						$dari = ($this->hal - 1) * $this->baris;
						$sampai = $this->baris;
					}
					if($this->CI->input->post('orderby')){
						$this->orderby = $this->CI->input->post('orderby');
					}
					if($this->CI->input->post('sortby')){
						$this->sortby = $this->CI->input->post('sortby');
					}
					$table_data .= " ORDER BY $this->orderby $this->sortby LIMIT $dari, $sampai";
				}
				#echo $table_data;
				$table_data = $this->db->query($table_data);
				$this->_set_from_object($table_data);
			}
		}
	
		if (count($this->heading) == 0 AND count($this->rows) == 0){
			return 'Undefined table data';
		}
		$this->_compile_template();
		$out .= "<div id=\"".$this->divid."\">";
		$out .= "<form id='".$this->formid."' name='".$this->formid."'  action='".$this->actions."' onsubmit=\"newtable_search('".$this->formid."','".$this->divid."','1','".$this->sortby."','".$this->orderby."'); return false;\" autocomplete='off'>";
		if ($this->show_search){
			$out .=	'	<div class="row">';
			if($this->multiple_search){
				foreach ($this->keycari as $a => $b){
					if($b[2]=="DATERANGE"){
						$out .=	'<div class="form-group">';
							$out .=	'<label class="control-label col-sm-2" for="'.$a.'1">'.$b[1].'</label>';
							$out .=	'<div class="col-sm-2">';
							$out .=	'<input type="text" name="form['.$a.'][]" id="'.$a.'1" class="date form-control" value="'.$arrvalcari[$a][0].'" placeholder="TANGGAL AWAL" tag="'.$b[2].'">';
							$out .=	'</div>';
							$out .=	'<div class="col-sm-2">';
							$out .=	'<input type="text" name="form['.$a.'][]" id="'.$a.'2" class="date form-control" value="'.$arrvalcari[$a][1].'" placeholder="TANGGAL AKHIR" tag="'.$b[2].'">';
							$out .=	'</div>';
						$out .=	'</div>';
					}else if($b[2]=="OPTION"){
						$out .=	'<div class="form-group">';
						$out .=	'<label class="col-sm-2 control-label" for="'.$a.'">'.$b[1].'</label>';
						$out .=	'<div class="col-sm-10">';
						$out .=	'<select name="form['.$a.'][]" id="'.$a.'" class="form-control">';
						if(count($b[3]) > 0){
							foreach($b[3] as $opt => $valopt){
								$selected_opt = "";
								if($arrvalcari[$a][0]==$opt) $selected_opt = "selected='selected'";
								$out .=	'<option value="'.$opt.'" '.$selected_opt.'>'.$valopt.'</option>';
							}
						}
						$out .=	'</select>';
						$out .=	'</div>';
						$out .=	'</div>';
					}else{
						$out .=	'<div class="form-group">';
						$out .=	'	<label class="col-sm-2 control-label" for="'.$a.'">'.$b[1].'</label>';
						$out .=	'	<div class="col-sm-10">';
						$out .=	'		<input id="'.$a.'" class="form-control" type="text" name="form['.$a.'][]" value="'.$arrvalcari[$a][0].'" tag="'.$b[2].'" placeholder="'.$b[1].'">';
						$out .=	'	</div>';
						$out .=	'</div>';
					}
				}
				$out .=	'<div class="form-group">';
				$out .=	'<div class="col-sm-12" align="center">';
				$out .=	'<button type="reset" class="btn btn-sm btn-maroon btn-reset"><i class="fa fa-refresh"></i> CANCEL</button>&nbsp;';
				$out .= "<button type=\"submit\" onclick=\"newtable_search('".$this->formid."','".$this->divid."','".$this->hal."','".$this->sortby."','".$this->orderby."'); return false;\" class=\"btn btn-sm btn-lightblue\"><i class='fa fa-search'></i> SEARCH</button>";
				$out .=	'	</div>';
				$out .=	'</div>';
			}else{
				$out .=	'<div class="form-group">';
				$out .=	'<label class="col-sm-2 control-label" for="'.$a.'">SEARCH BY</label>';
				$out .=	'<div class="col-sm-3">';
				$out .= '<select class="form-control" name="form[]" '.$disabled.'">';
						foreach ($this->keycari as $a => $b){
							if($arrvalcari[0]==$a) $out .= '<option selected value="';
							else $out .= '<option value="';
							$out .= $a;
							$out .= '"';
							$out .= ' tag="'.strtolower($b[2]).'">';
							$out .= $b[1];
							$out .= '</option>';
						}
						$out .= '</select>';
				$out .=	'</div>';
				$out .=	'<div class="col-sm-7">';
				$out .= '<input type="text" class="form-control" name="form[]" '.$disabled.' value="'.$arrvalcari[1].'" placeholder="PENCARIAN DATA"/>';
				$out .=	'</div>';
				$out .=	'</div>';
				$out .=	'<div class="form-group">';
				$out .=	'<div class="col-sm-12" align="center">';
				$out .=	'<button type="reset" class="btn btn-sm btn-maroon btn-reset"><i class="fa fa-refresh"></i> CANCEL</button>&nbsp;';
				$out .= "<button type=\"submit\" onclick=\"newtable_search('".$this->formid."','".$this->divid."','".$this->hal."','".$this->sortby."','".$this->orderby."'); return false;\" class=\"btn btn-sm btn-lightblue\"><i class='fa fa-search'></i> SEARCH</button>";
				$out .=	'	</div>';
				$out .=	'</div>';
			}
			$out .=	'	</div>';

			// if(count($this->proses) < 1 && $this->show_menu){
				$out .= "<br/>";
			// }
		}
		if($this->show_column) $colspan = (count($this->heading) + count($this->column));
		else $colspan = count($this->heading);
		$out .= $this->template['table_open'];
		if(count($this->proses) > 0 && $this->show_menu){
			$out .= '<div class="pull-left">';
			$out .= '<div class="btn-group mb5">';
			if($this->tipe_proses=="button"){
				$m = 0;
				foreach ($this->proses as $a => $b){
					$out.="<button type=\"button\" onclick=\"button_menu('".$this->formid."',this.id)\" id=\"tb_menu".$this->formid.$m."\" formid=\"".$this->formid."\" div=\"".$this->divid."\" met=\"".$b[0]."\" url=\"".$b[1]."\" jml=\"".$b[2]."\" status=\"".$b[3]."\" popup=\"".$b[5]."\" class=\"btn btn-white tooltips\" title=\"".$a."\" data-placement=\"top\" data-toggle=\"tooltip\"><i class=\"".$b[4]."\" div=\"".$this->divid."\"></i></button>";
					$out.="&nbsp;";
					$m++;
				}
			}else{
				$out .= "<select id=\"tb_menu".$this->formid."\" title=\"Pilih proses yang akan dijalankan\" formid=\"".$this->formid."\" onChange=\"tb_menu('".$this->formid."')\" class=\"tb_menu\"><option url=\"\">Pilih Proses &nbsp;&nbsp;</option>";
				foreach ($this->proses as $a => $b){
					$out .= '<option met="';
					$out .= $b[0];
					$out .= '" jml="';
					$out .= $b[2];
					$out .= '" url="';
					$out .= $b[1];
					$out .= '" div="';
					$out .= $this->divid;
					$out .= '">';
					$out .= "- $a";
					$out .= '</option>';
				}
				$out .= '</select>';
			}
			$out .= '</div></div>';
		}
		
		if (count($this->rows) == 0){
			$disabled = "";	
		}
		
		if ($this->show_search || $this->show_chk || $this->show_no ||  $this->show_menu){
			#$out .= '</th></tr>';
		}
		
		if ($this->caption){
			$out .= $this->newline;
			$out .= '<caption>' . $this->caption . '</caption>';
			$out .= $this->newline;
		}
		if (count($this->rows) > 0){
			if (count($this->heading) > 0){
				$out .= $this->template['heading_rows_start'];
				$out .= $this->template['heading_row_start'];
				$out .= $this->newline;
				foreach($this->heading as $z => $heading){
					if (!in_array($heading, $this->hiderows)){
						if ( $z == 0 && $this->show_no){
							$out .= '<th width="1" '.$this->header_bg.'>';
							$out .= $heading;
						}
						elseif ( $z == 1 && $this->show_chk ){
							$out .= '<th width="30" '.$this->header_bg.'>';
							$out .= $heading;
						}else{
							$z--;
							$out .= $this->template['heading_cell_start'];
							if ( $this->baris != "ALL"){
								if($z==$this->orderby){
									if($this->sortby=="ASC"){
										$out .= "<span onclick=\"newtable_search('".$this->formid."','".$this->divid."','".$this->hal."','DESC','".$z."')\" class=\"order\" title=\"Order by ".$heading." (Z-A)\" orderby=\"$z\" sortby=\"DESC\">$heading &nbsp;<i class=\"glyphicon glyphicon-sort-by-attributes\"></i></span>";
									}else{
										$out .= "<span onclick=\"newtable_search('".$this->formid."','".$this->divid."','".$this->hal."','ASC','".$z."')\" class=\"order\" title=\"Order by ".$heading." (A-Z)\" orderby=\"$z\" sortby=\"ASC\">$heading &nbsp;<i class=\"glyphicon glyphicon-sort-by-attributes-alt\"></i></span>";
									}
								}else{
									$out .= "<span onclick=\"newtable_search('".$this->formid."','".$this->divid."','".$this->hal."','ASC','".$z."')\" class=\"order\" title=\"Order by ".$heading." (A-Z)\" orderby=\"$z\" sortby=\"ASC\">$heading</span>";
								}
							}
							else{
								$out .= "<span class=\"order\" orderby=\"$z\" sortby=\"ASC\">$heading</span>";
							}
						}
						$out .= $this->template['heading_cell_end'];
					}
				}
				if($this->show_column){
					foreach ($this->column as $a => $b){
						//$out .= '<th>'.$a.'</th>';
					}		
				}
				if($this->detail[0]=="PREVIEW") $out .= '<th width="22" '.$this->header_bg.'>&nbsp;</th>';
				$out .= $this->template['heading_row_end'];
				$out .= $this->template['heading_rows_end'];
				$out .= $this->newline;				
			}
		}else{
			$out .="";
		}

		if (count($this->rows) > 0){
			$this->page = 1;
			if($this->hal<=1){
				$x = 1;
				$y = 0;
			}	
			else{
				$x = ($this->hal - 1) * $this->baris + 1;
				$y = ($this->hal - 1) * $this->baris;
			}
			
			$i = 1;
			$cls="odd";
			$tmpchkarray = array();
			$tmpvalue = "";
			$tmpchk = "";
			if($this->checked_val){
				$tmpchk = $this->checked_val;
				$arrexpchk = explode("*",$tmpchk);
				for($a=0; $a<count($arrexpchk); $a++){
					$tmpchkarray[] = $arrexpchk[$a];
				}
			}else{
				if ($tmpchk = $this->CI->input->post('tmpchk'.$this->formid)){
					$arrexpchk = explode("*",$tmpchk);
					for($a=0; $a<count($arrexpchk); $a++){
						$tmpchkarray[] = $arrexpchk[$a];
					}
				}
			}
			foreach($this->rows as $row){
				if (!is_array($row)){
					break;
				}
				$keyz = "";
				$koma = "";
				$keypilih = "";
				$batas = "";
				foreach ($this->keys as $a){
					$keyz .= $koma.$row[$a];
					$koma = "~";
					$keypilih .= $batas.$row[$a];
					$batas = ";";
				}
				$valid = "";
				$sparator = "";
				$line = "";
				$choose = "";
				foreach ($this->validasi as $z){
					$valid .= $sparator.$row[$z];
					$sparator = "|";
					$choose .= $line.$row[$z];
					$line = ";";
				}
				$name = (fmod($i++, 2)) ? '' : 'alt_';
				$field = "";
				foreach ($this->indexField as $b){
					$field .= $b.";";
				}
				if($arrdetail = $this->detail){
					foreach($arrdetail as $data => $value){
						if($arrdetail[0]=="GET"){
							$out .= "<tr id=\"tr_".$x."\" title=\"DOUBLE CLICK TO PREVIEW\" url=\"".$arrdetail[1]."\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" type=\"GET\" ondblclick=\"get_detail(this)\" onclick=\"tr_chk('".$this->formid."',this)\" value=\"".$ENCRIPT->azdgcrypt->crypt($keyz)."\" formdata=\"".$this->formid."\">";
						}else if($arrdetail[0]=="POPUP"){
							$out .= "<tr id=\"tr_".$x."\" title=\"DOUBLE CLICK TO PREVIEW\" url=\"".$arrdetail[1]."\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\"  type=\"POPUP\" ondblclick=\"get_detail(this)\" onclick=\"tr_chk('".$this->formid."',this)\" value=\"".$ENCRIPT->azdgcrypt->crypt($keyz)."\" formdata=\"".$this->formid."\">";
						}else if($arrdetail[0]=="PREVIEW") {
							$out .= "<tr id=\"tr_".$x."\" title=\"CLICK TO PREVIEW DETAILS\" urldetil=\"".$arrdetail[1]."\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\"  type=\"PREVIEW\" onclick=\"td_detil_priview_bottom('".$this->formid."',this)\" value=\"".$ENCRIPT->azdgcrypt->crypt($keyz)."\" formdata=\"".$this->formid."\">";
						}
					}
				}else{
					$out .= "<tr id=\"tr_".$x."\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\" onclick=\"tr_chk('".$this->formid."',this)\">";
				}
				
				$out .= $this->newline;	
				if($cls=="odd"){
					$cels = $this->template['cell_alt'];	
				}else{
					$cels = $this->template['cell_odd'];
				}
				$out .= $cels.$x.'</td>';
				if(in_array($keyz,$tmpchkarray)) $checked = "checked";
				else $checked = "";
				if ($this->show_chk){
					if(count($this->checked) > 0){
						$check = "";
						foreach ($this->checked as $y){
							if($this->CI->input->post('ajax')){
								$check = $this->CI->input->post('tmpchk'.$this->formid);
							}else{
								if($row[$y] != ""){
									$checked = "checked";
									$check = $keyz;
								}else{
									$checked = "";
									$check = "";
								}
							}
						}
						$arrchk[] = $check;
					}
					if ($this->check == "radio") {
						$out .= $cels."<div class='rdio rdio-success'><input type=\"".$this->check."\" name=\"tb_chk".$this->formid."[]\" id=\"tb_chk".$this->formid.$x."\" class=\"tb_chk".$this->formid."\" $checked value=\"".$ENCRIPT->azdgcrypt->crypt($keyz)."\" validasi=\"".$valid."\" onclick=\"tb_chk('".$this->formid."',this.checked,this.value)\" data=\"".$x."\"/><label for=\"tb_chk".$this->formid.$x."\"></label></div></td>";	
					} else {
						$out .= $cels."<div class='ckbox ckbox-success'><input type=\"".$this->check."\" name=\"tb_chk".$this->formid."[]\" id=\"tb_chk".$this->formid.$x."\" class=\"tb_chk".$this->formid."\" $checked value=\"".$ENCRIPT->azdgcrypt->crypt($keyz)."\" validasi=\"".$valid."\" onclick=\"tb_chk('".$this->formid."',this.checked,this.value)\" data=\"".$x."\"/><label for=\"tb_chk".$this->formid.$x."\"></label></div></td>";	
					}
				}
				foreach($row as $rowz => $cell){
					if ( !in_array($rowz, $this->hiderows)){
						$out .= $cels;
						if ($cell === ""){
							$out .= $this->empty_cells;
						}
						else{
							$out .= html_entity_decode($cell);
						}
						$out .= $this->template['cell_'.$name.'end'];
					}
				}
				
				if($this->detail[0]=="PREVIEW") {
					$out .= $cels."<img src=\"".base_url()."assets/images/nolines_plus.gif\" alt=\"\" title=\"Expand\" btnname=\"expand\" class=\"expand\"></td>";
				}
				
				$arrvalues = array();
				if($key_input = $this->CI->input->post('input')){
					foreach($key_input as $a => $b){
						$arrvalues[$a] = $b;
					}
				}
				if($this->show_column){
					foreach($this->column as $a => $b){
						if($b[0]=="text"){
							//$out .= $cels."<input type=\"text\" name=\"".$b[1].$y."\" id=\"".$b[2].$y."\" class=\"".$b[3]."\" value=\"".$this->CI->input->post($b[1].$y)."\" $b[5]></td>";
							$out .= $cels."<input type=\"text\" name=\"input[".$b[1]."][]\" id=\"".$b[2].$y."\" class=\"".$b[3]."\" value=\"".$arrvalues[$b[1]][$y]."\" $b[5]></td>";
						}else if($b[0]=="textarea"){
							//$out .= $cels."<textarea name=\"".$b[1].$y."\" id=\"".$b[2].$y."\" class=\"".$b[3]."\" $b[5]>".$this->CI->input->post($b[1].$y)."</textarea></td>";
							$out .= $cels."<textarea name=\"input[".$b[1]."][]\" id=\"".$b[2].$y."\" class=\"".$b[3]."\" $b[5]>".$arrvalues[$b[1]][$y]."</textarea></td>";
						}
					}
				}
				
				$out .= $this->template['row_'.$name.'end'];
				$out .= $this->newline;	
				$x++;
				$y++;
				if($cls=="alt"){$cls="odd";}elseif($cls=="odd"){$cls="alt";}
			}
		}
		else{
			$out .= $this->template['heading_rows_start'];
			$out .= '<tr><th colspan="'.count($this->heading).'"><center>NO RECORD FOUND</center></th></tr>';
			$out .= $this->template['heading_rows_end'];
		}
		
		if( $this->baris != "ALL" && $this->show_paging){
			$datast = ($this->hal - 1);
			if($datast<1) $datast = 1;
			else $datast = $datast * $this->baris + 1;
			$dataen = $datast + $this->baris - 1;
			if($total_record < $dataen) $dataen = $total_record;
			if($total_record==0) $datast = 0;
			if($total_record==1) $txt_record = "RECORD.";
			else $txt_record = "RECORDS.";
			if($this->show_column) {
				$colspan = (count($this->heading) + count($this->column));
			}  else {
				if(count($this->hiderows) > 1) {
					$colspan = count($this->heading) - (count($this->hiderows) - 1);
				} else {
					$colspan = count($this->heading);
				}
			}

			if($this->detail[0]=="PREVIEW") $colspan += 1;

			if (count($this->rows) > 0){
				$eventExec = "newtable_search('".$this->formid."', '".$this->divid."','".$this->hal."','".$this->sortby."','".$this->orderby."');";
				$out .='<tr class="headcontent">
							<th colspan="'.$colspan.'"><div class="col-sm-1" style="margin-left:-15px; margin-top: 0px; width:80px;" id="per-page-'.$this->divid.'">'.form_dropdown('', array("10"=>"10",'50'=>'50','100'=>'100'), $this->baris, 'id="combo-per-page-'.$this->divid.'" class="form-control" onChange="'.$eventExec.'" style="width:70px !important;" name="limit"').'</div>
							<input type="hidden" class="tb_text" id="tb_view" value="'.$this->baris.'" readonly/> <span style="float:left; padding-top:10px;">&nbsp;RECORDS PER PAGE. SHOWING '.$datast.' - '.$dataen.' OF '.$total_record.' '.$txt_record."</span>";
				if($total_record > $this->baris){ 
					$prev = $this->hal-1;
					$next = $this->hal+1;
					$firstExec = "newtable_search('".$this->formid."', '".$this->divid."','1','".$this->sortby."','".$this->orderby."');";
					$prevExec  = "newtable_search('".$this->formid."', '".$this->divid."','".$prev."','".$this->sortby."','".$this->orderby."');";
					$nextExec  = "newtable_search('".$this->formid."', '".$this->divid."','".$next."','".$this->sortby."','".$this->orderby."');";
					$lastExec  = "newtable_search('".$this->formid."', '".$this->divid."','".$total_record."','".$this->sortby."','".$this->orderby."');";
					$out .="<span style=\"float:right; margin-top:5px;\">";
					if ($this->hal != "1"){
						$out .="<button type=\"button\" onclick=\"".$firstExec."\" title=\"First\" class=\"btn btn-primary btn-xs\"><i class='fa fa-fast-backward'></i></button>";
						$out .="&nbsp;<button type=\"button\" onclick=\"".$prevExec."\" title=\"Prev\" class=\"btn btn-primary btn-xs\"><i class='fa fa-step-backward'></i></button>&nbsp;";
					}else{
						$out .="&nbsp;<button type=\"button\" disabled=\"disabled\" class=\"btn btn-primary btn-xs\"><i class='fa fa-fast-backward'></i></button>";
						$out .="&nbsp;<button type=\"button\" disabled=\"disabled\" class=\"btn btn-primary btn-xs\"><i class='fa fa-step-backward'></i></button>&nbsp;";
					}
					$out .="Page <input type=\"text\" id=\"tb_hal".$this->formid."\" value=\"".$this->hal."\" ".$disabled."  ondblclick=\"".$nextExec."\" style=\"width:30px;height:26px;text-align:center;\"/>"; 
					$out .="&nbsp;<button type=\"button\" class=\"btn btn-xs btn-primary\" OnClick=\"newtable_search('".$this->formid."', '".$this->divid."',document.getElementById('tb_hal".$this->formid."').value,'".$this->sortby."','".$this->orderby."');\">Go</button>";
					$out .=" Of ".$table_count;
					
					if ($this->hal != ($table_count)){
						$out .="&nbsp;<button type=\"button\" onclick=\"".$nextExec."\" title=\"Next\" class=\"btn btn-primary btn-xs\"><i class='fa fa-step-forward'></i></button>";
						$out .="&nbsp;<button type=\"button\" onclick=\"".$lastExec."\" title=\"Last\" class=\"btn btn-primary btn-xs\"><i class='fa fa-fast-forward'></i></button>&nbsp;";
					}else{
						$out .="&nbsp;<button type=\"button\" disabled=\"disabled\" class=\"btn btn-primary btn-xs\"><i class='fa fa-step-forward'></i></button>";
						$out .="&nbsp;<button type=\"button\" disabled=\"disabled\" class=\"btn btn-primary btn-xs\"><i class='fa fa-fast-forward'></i></button>&nbsp;";
					}
					$out .="</span>";
				}else{
					$out .="<input type=\"hidden\" class=\"tb_text\" id=\"tb_hal".$this->formid."\" value=\"".$this->hal."\" ".$disabled."  ondblclick=\"".$nextExec."\" style=\"width:30px;text-align:right;\"/>"; 	
				}
				$out .='</th></tr>';
			}
		}
		else
		{
			if($this->show_column) $colspan = (count($this->heading) + count($this->column));
			else $colspan = count($this->heading);
			if($total_record==1) $txt_record = " RECORD DATA."; 
			else $txt_record = " RECORDS DATA.";
			$out .= '<tr class="headcontent">
				<th colspan="'.$colspan.'">
					<span>'.$total_record.$txt_record.'</span>
				</th>
			</tr>';
		}
		$out .= $this->template['table_close'];
		if(count($arrchk) > 0){
			for($a=0; $a<count($arrchk); $a++){
				if($this->CI->input->post('ajax')){
					$tmpchk = $this->CI->input->post('tmpchk'.$this->formid);
				}else{
					if($arrchk[$a]!="") $tmpchk .= $arrchk[$a]."*";
				}
			}
		}
		$out .= '<input type="hidden" class=\'form-control\' name="tmpchk'.$this->formid.'" id="tmpchk'.$this->formid.'" value="'.$tmpchk.'" mandatory="yes" readonly>';
		$out .='</form>';
		$out .='</div>';
		$out .='<script>$(function(){$(\'[data-toggle="tooltip"]\').tooltip(); date(\'date\') });</script>';
		return $out;	
	}
	
	function clear(){
		$this->rows				= array();
		$this->heading			= array();
		$this->auto_heading		= TRUE;	
		$this->template 		= NULL;
	}
	
	function _set_from_object($query)
	{
		if ( ! is_object($query))
		{
			return FALSE;
		}
		
		if (count($this->heading) == 0)
		{
			if ( ! method_exists($query, 'list_fields'))
			{
				return FALSE;
			}
			empty($this->heading);
			if( $this->show_no ) $this->heading[] = '<center>NO</center>';
			if( $this->show_chk ){
				if($this->check != "radio"){
					$this->heading[] .= "<div class='ckbox ckbox-success'><input type=\"checkbox\" id=\"tb_chkall".$this->formid."\" onclick=\"tb_chkall('".$this->formid."',this.checked)\" class=\"tb_chkall\"/><label for=\"tb_chkall".$this->formid."\"></label></div>";
				}else{
					$this->heading[] .= "&nbsp;";
				}
			}
			foreach ($query->list_fields() as $a){
				$this->heading[] = $a;
			}
		}
		
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$this->rows[] = $row;
			}
		}
	}

	function _set_from_array($data, $set_heading = TRUE)
	{
		if ( ! is_array($data) OR count($data) == 0)
		{
			return FALSE;
		}
		
		$i = 0;
		foreach ($data as $row)
		{
			if ( ! is_array($row))
			{
				$this->rows[] = $data;
				break;
			}
						
			if ($i == 0 AND count($data) > 1 AND count($this->heading) == 0 AND $set_heading == TRUE)
			{
				$this->heading = $row;
			}
			else
			{
				$this->rows[] = $row;
			}
			
			$i++;
		}
	}

 	function _compile_template()
 	{ 	
 		if ($this->template == NULL)
 		{	
 			$this->template = $this->_default_template();
 			return;
 		}
			
		$this->temp = $this->_default_template();
		foreach (array('table_open','heading_rows_start','heading_rows_end','heading_body_start','heading_body_end','heading_row_start', 'heading_row_end', 'heading_cell_start', 'heading_cell_end', 'row_start', 'row_end', 'cell_start','cell_alt','cell_odd', 'cell_end', 'row_alt_start', 'row_alt_end', 'cell_alt_start', 'cell_alt_end', 'table_close') as $val)
		{
			if ( ! isset($this->template[$val]))
			{
				$this->template[$val] = $this->temp[$val];
			}
		} 	
 	}
	
	function _size(){
		
	}
	
	function _default_template(){
		if($this->header_bg) $this->header_bg = 'style="'.$this->header_bg.'"';
		return  array (
						'table_open' 			=> '<table id="'.$this->formid.'" class="tabelajax" >',
						'heading_rows_start' 	=> '<thead>',
						'heading_rows_end' 		=> '</thead>',
						'heading_body_start' 	=> '<tbody>',
						'heading_body_end' 		=> '</tbody>',
						'heading_row_start' 	=> '<tr>',
						'heading_row_end' 		=> '</tr>',
						'heading_cell_start'	=> '<th '.$this->header_bg.'>',
						'heading_cell_end'		=> '</th>',
						'row_start' 			=> "<tr>",
						'row_end' 				=> '</tr>',
						'cell_start'			=> '<td '.$this->td_click.'>',
						'cell_alt'				=> '<td '.$this->td_click.' class="alt">',
						'cell_odd'				=> '<td '.$this->td_click.' class="odd">',
						'cell_end'				=> '</td>',
						'row_alt_start' 		=> '<tr>',
						'row_alt_end' 			=> '</tr>',
						'cell_alt_start'		=> '<td '.$this->td_click.'>',
						'cell_alt_end'			=> '</td>',
						'table_close' 			=> '</table>'
					);	
	}
	
	function initialize($params = array()){
		if (count($params) > 0){
			foreach ($params as $key => $val){
				if (isset($this->{'_' . $key})){
					$this->{'_' . $key} = $val;
				}
			}
		}
	}
	
	function breadcrumb($title, $href, $icon){
	  if (!$title or !$href) return;
	  	$this->breadcrumbs[] = array('title' => strtoupper($title), 'href' => $href, 'icon' => $icon);	
	}
	
  	function output(){
		if ($this->breadcrumbs){
			foreach ($this->breadcrumbs as $key => $crumb) {
				if ($key){ 
  					$output .= $this->separator;
				}
				if (end(array_keys($this->breadcrumbs)) == $key) {
					$output .= '<li class="active"><i class="'.$crumb['icon'].'"></i>' . $crumb['title'] . '</li>';
				} else {
					$output .= '<li><a href="' . $crumb['href'] . '"><i class="'.$crumb['icon'].'"></i> '. $crumb['title'] . '</a></li>';
				}
			}
  			return $output;
		}
  		return "";
  	}
	
}