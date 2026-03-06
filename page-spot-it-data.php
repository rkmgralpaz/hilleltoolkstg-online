<?php
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
    defined( 'ABSPATH' ) or die( 'This page cannot be accessed directly.' );
    
	if(!is_user_logged_in()):
		$url = home_url("/wp-admin/");
		wp_redirect( $url );
		exit;
	endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spot It Data – Campus for All</title>
    <meta name="robots" content="noindex">
    <style>
        html,body{
            padding: 0;
            margin: 0;
            font-family: sans-serif;
        }
        .wrapper{
            width: fit-content;
            margin: 0 auto;
            padding: 0 30px;
            padding-bottom: 50px;
            min-width: 1250px;
        }
        .header{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        a{
            color: black;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 3px;
        }
        h1{
            width: fit-content;
        }
        table{
            position: relative;
            border-collapse: collapse;
            width: 100%;
        }
        table th{
            position: sticky;
            top: 0;
            background: #111;
            color: white;
            font-weight: normal;
        }
        table th,
        table td{
            padding: 8px 10px;
        }
        table tr:nth-child(odd){
            background: #E7E7E7;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>Spot It Data</h1>
            <a href="<?php echo esc_url(get_template_directory_uri()); ?>/spot-it.csv" download>Download as CSV file</a>
        </header>
        <table border="1">
            <?php
            //
            $csv = file('./wp-content/themes/hillel-combating-antisemitism/spot-it.csv');
            array_push($csv,array_shift($csv));
            $csv = array_reverse($csv);
            //
            $html = '';
            $i = 0;
            $total = count($csv);
            foreach ($csv as $row):
                if($i == 0):
                    $num = '';
                    $tag = 'th';
                else:
                    $num = $i;
                    $tag = 'td';
                endif;
                $html .= '<tr>';
                $html .= "<{$tag}>{$num}</{$tag}>";
                $cells = explode(';',$row);
                if($i > 0):
                    $cells[5] = date('M j, Y g:i a',strtotime($cells[5]));
                endif;
                foreach ($cells as $cell):
                    $html .= "<{$tag}>{$cell}</{$tag}>";
                endforeach;
                $html .= '</tr>';
                $i++;
            endforeach;
            //
            echo $html;
            ?>
        </table>
    </div>
</body>
</html>
