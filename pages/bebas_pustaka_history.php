<?php
/**
 * @Created by          : Erwan Setyo Budi
 * @Date                : 2022-06-08 13:47:37
 * @File name           : index.php
 */


use SLiMS\Pdf\Factory;
use SLiMS\DB;

defined('INDEX_AUTH') OR die('Direct access not allowed!');

// start the session
require SB . 'admin/default/session.inc.php';
require SB . 'admin/default/session_check.inc.php';
// set dependency
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';
// end dependency

// privileges checking
$can_read = utility::havePrivilege('membership', 'r');

if (!$can_read) {
    die('<div class="errorBox">' . __('You are not authorized to view this section') . '</div>');
}

if (preg_replace('/[^0-9]/', '', SENAYAN_VERSION_TAG) < 961) {
    die('<div class="errorBox font-weight-bold">Versi SLiMS anda tidak mendukung plugin ini. ('.SENAYAN_VERSION_TAG.' != v9.6.1)</div>');
}

function httpQuery($query = [])
{
    return http_build_query(array_unique(array_merge($_GET, $query)));
}

$page_title = 'Daftar Bebas Pustaka';

/* Action Area */
$max_print = 50;

/* Action Area */
if (isset($_GET['action']) && $_GET['action'] === 'clear')
{
    // clear session
    if (isset($_SESSION['bebas_pustaka'])) $_SESSION['bebas_pustaka'] = [];

    // unset ession
    unset($_GET['action']);

    // Set alert
    utility::jsToastr('Sukses', 'atrian cetak berhasil dibersihkan', 'success');

    echo <<<HTML
    <script>
        parent.document.querySelector('#queueCount').innerHTML = 0;
    </script>
    HTML;
    exit;
}

if (isset($_POST['itemID']))
{
    if (!isset($_SESSION['bebas_pustaka'])) $_SESSION['bebas_pustaka'] = [];

    if ((count($_POST['itemID']) + count($_SESSION['bebas_pustaka'])) > $max_print) {
        toastr('Antrian melebihi batas maksimal')->error();
        exit;
    }

    $_SESSION['bebas_pustaka'] = array_merge($_SESSION['bebas_pustaka'], $_POST['itemID']);
    utility::jsToastr('Sukses', 'Berhasil menambkan data kedalam antrian cetak', 'success');
    $queueCount = count($_SESSION['bebas_pustaka']);
    echo <<<HTML
    <script>
        parent.document.querySelector('#queueCount').innerHTML = {$queueCount};
    </script>
    HTML;
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'settings') {
    include_once __DIR__ . DS . 'settings.php';
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'print')
{
    if (count($_SESSION['bebas_pustaka']) < 1) {
        include_once __DIR__ . DS . 'nodata_to_print.php';
        exit;
    }
    // Register provider
    $provider = config('bebas_pustaka.default_provider', [
        'MyDompdf', \BebasPustaka\Providers\Dompdf::class
    ]);
    Factory::registerProvider(...$provider);

    Factory::useProvider($provider[0]);

    $questionMark = trim(str_repeat('?,', count($_SESSION['bebas_pustaka'])), ',');
    $member = DB::getInstance()->prepare('
        SELECT m.member_id, 
               m.member_name, 
               mt.member_type_name, 
               m.member_address 
        FROM member AS m 
        LEFT JOIN mst_member_type AS mt ON m.member_type_id = mt.member_type_id 
        WHERE m.member_id IN (' . $questionMark . ')
    ');
    $member->execute($_SESSION['bebas_pustaka']);


    $content = [];
    while ($data = $member->fetch(PDO::FETCH_ASSOC)) {
        $content[] = $data;
    }

    $_SESSION['bebas_pustaka'] = [];
    Factory::setContent($content)->stream();
    exit;
}

/* End Action Area */
?>
<div class="menuBox">
    <div class="menuBoxInner memberIcon">
        <div class="per_title">
            <h2><?php echo $page_title; ?></h2>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a target="blindSubmit" href="<?= $_SERVER['PHP_SELF'] . '?' . httpQuery(['action' => 'clear']) ?>" class="notAJAX btn btn-danger mx-1"><?= __('Clear Print Queue') ?></a>
                <a href="<?= $_SERVER['PHP_SELF'] . '?' . httpQuery(['action' => 'print']) ?>" id="print" width="765" height="500" class="notAJAX openPopUp btn btn-primary mx-1">Cetak Kembali Surat Bebas Pustaka</a>
                <!-- <a href="<?= $_SERVER['PHP_SELF'] . '?' . httpQuery(['action' => 'settings']) ?>" id="setting" class="notAJAX btn btn-default openPopUp mx-1" title="Ubah Pengaturan Bebas Pustaka">Ubah Pengaturan Bebas Pustaka</a> -->
            </div>
            <form name="search" action="<?= $_SERVER['PHP_SELF'] . '?' . httpQuery() ?>" id="search" method="get" class="form-inline"><?php echo __('Search'); ?>
                <input type="text" name="keywords" class="form-control col-md-3"/>
                <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>"
                        class="s-btn btn btn-default"/>
            </form>
        </div>
        <div class="infoBox">
        <?php
        echo __('Maximum').' <strong class="text-danger">'.$max_print.'</strong> '.__('records can be printed at once. Currently there is').' ';
        if (isset($_SESSION['bebas_pustaka'])) {
            echo '<strong id="queueCount" class="text-danger">'.count($_SESSION['bebas_pustaka']).'</strong>';
        } else { echo '<strong id="queueCount" class="text-danger">0</strong>'; }
        echo ' '.__('in queue waiting to be printed.');
        ?>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#print').click(function(e) {
                if ($('#queueCount').html() > 0) {
                    $('#queueCount').html('0')
                }
            })

            // set popup
            let setting = $('#setting')
            setting.attr('width', parseInt(window.innerWidth) - 125)
            setting.attr('height', parseInt(window.innerHeight)  - 125)
        })
    </script>
</div>

<?php
/* Datagrid area */

/**
 * table spec
 */
$table_spec = 'member as m 
               LEFT JOIN mst_member_type as mt ON m.member_type_id = mt.member_type_id
               INNER JOIN bebas_pustaka_history as bph ON m.member_id = bph.member_id';

// membuat datagrid
$datagrid = new simbio_datagrid();

/** 
 * Menyiapkan kolom
 */
$datagrid->setSQLColumn(
    'm.member_id AS ID_Anggota', 
    'm.member_name AS Nama_Anggota',
    'm.member_id AS ID_Anggota', 
    'mt.member_type_name AS Jenis_Keanggotaan',
    'bph.id AS Nomor_Surat',
    'bph.letter_number_format AS Format_Nomor_Surat',
    'bph.created_at AS Tanggal_Dibuat',
    'bph.updated_at AS Terakhir_Diperbarui'
);

/** 
 * Pencarian data
 */
$criteria = '1'; // Menggunakan 1 sebagai default agar mudah ditambahkan kondisi lain

if (isset($_GET['keywords']) && $_GET['keywords']) {
    $keywords = utility::filterData('keywords', 'get', true, true, true);
    $criteria .= ' AND (m.member_id LIKE "%' . $keywords . '%" 
                   OR m.member_name LIKE "%' . $keywords . '%"
                   OR bph.letter_number_format LIKE "%' . $keywords . '%")';
}

$datagrid->setSQLCriteria($criteria);

/** 
 * Atribut tambahan
 */
$datagrid->table_attr = 'id="dataList" class="s-table table"';
$datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
$datagrid->edit_property = false;
$datagrid->chbox_property = array('itemID', __('Add'));
$datagrid->chbox_action_button = __('Add To Print Queue');
$datagrid->chbox_confirm_msg = __('Add to print queue?');
$datagrid->column_width = array('5%', '30%', '15%', '10%', '20%', '10%', '10%');

// set checkbox action URL
$datagrid->chbox_form_URL = $_SERVER['PHP_SELF'] . '?' . httpQuery();

// Debugging: Periksa apakah kolom ID_Anggota muncul
// print_r($datagrid->column);
// die();

// generate data grid
$datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, true);

if (isset($_GET['keywords']) && $_GET['keywords']) {
    $msg = str_replace('{result->num_rows}', $datagrid->num_rows, __('Found <strong>{result->num_rows}</strong> from your keywords'));
    echo '<div class="infoBox">' . $msg . ' : "' . htmlspecialchars($_GET['keywords']) . '"<div>' . __('Query took') . ' <b>' . $datagrid->query_time . '</b> ' . __('second(s) to complete') . '</div></div>';
}

// menampilkan datagrid
echo $datagrid_result;

/* End datagrid */
