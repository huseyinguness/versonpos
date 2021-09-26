<?php require_once 'yonetim_fonksiyon/yonfonksiyon.php';$yokclas= new yonetim;

function excelal ()(
$filename='ExportExcel',
$colums=array(),
$colums2=array(),
$data=array(),
$data2=array(),
$virgulnerede=array(),
$veri1,
$veri2)
{
    header('Content-Encoding: UTF-8');
    header('Content-Type : text/plain; charset=utf-8');
    header('Content-disposition: attachment; filename='.$filename.'.xls');
        echo "\xEF\xBB\xBF"; //bom 

    $sayim=count($colums);
    echo '
    <table border="1"> 
    th style="background-color:"#000000" colspan="3"><font color="#FDFDFD"> Tarih </font>
    </th>
    <tr>';

        foreach ($colums as $v):
        echo '<th style="background-color:"#FFA500">'.trim($v).'</th>';
        endforeach;
        echo '</tr>';

        foreach ($data as $val):
        echo '<tr>';

            for ($i=0; $i < $sayim; $i++) : 
            if (in_array($i, $virgulnerede)):
                echo'<td>'.str_replase('.',',',$val[$i]).'</td>';
            else :
                echo'<td>'.$val[$i]).'</td>';
            endif;
           
            endfor;
         echo '</tr>';



        endforeach;



       




}

?>
			
