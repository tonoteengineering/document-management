<?php require_once('../private/initialize.php');

$page = 'Prepare';
$page_title = 'Document Preparation';
// $previous_page = $_SERVER['HTTP_REFERER'];

if($_GET['type'] == 1){ // Get Affidavit

    $record = Template::find_by_document_id($_GET['document_id']);
    $record->created_by != $loggedInAdmin->id ? redirect_to('../logout.php') : ''; 
    
    $documents = Template::find_by_document_ids($_GET['document_id']);
    $path = "templates/affidavit_template/";
    $title = $documents[0]->title;
    $previousPage = url_for('templates/');

    
}
// else if($_GET['type'] == 2 ){ // Request a Notary

//     $record = Document::find_by_document_id($_GET['document_id']);
//     $record->created_by != $loggedInAdmin->id ? redirect_to('../logout.php') : ''; 
//     $documents = Document::find_by_document_ids($_GET['document_id']);
//     $path = "document-edit/upload/raw_files/";
//     $title = $documents[0]->title;
//     $previousPage = url_for('document-edit/');
    
// }
else{ // Request a Notary or Sign a document
    $record = Document::find_by_document_id($_GET['document_id']);
    $record->created_by != $loggedInAdmin->id ? redirect_to('../logout.php') : ''; 
    
    $documents = Document::find_by_document_ids($_GET['document_id']);
    $path = "document-edit/upload/raw_files/";
    $title = $documents[0]->title;
    $previousPage = url_for('document-edit/');
}


include(SHARED_PATH . '/header.php');
?>
<style>
.wrap {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
}


.backdrop {
    background-color: rgb(0, 0, 0, 0.6);
}

.inner-wrapper {
    position: relative;
    width: auto;
    margin: 0.5rem;
    /* pointer-events: none; */
}
</style>
<link rel="stylesheet" type="text/css" href="css/pdf2img.css">



<div id="holder" style="width: 1000px; margin: 0 auto;"></div>
<canvas id="pdf-canvas" width="1000" height="842" style="display: none;"></canvas>
<input type="hidden" id="doc_type" value="<?php echo $_GET['type'] ?>" />
<input type="hidden" id="document_id" value="<?php echo $_GET['document_id']; //echo uniqid() ?>">
<input type="hidden" id="url_dir" value="<?php echo url_for('document-edit/edit.php?document_id=') ?>">
<?php foreach ($documents as $doc) : ?>
<input type="hidden" class="url" value="<?php echo url_for($path.$doc->filename); ?>">
<input type="hidden" class="title" value="<?php echo $title; ?>">
<?php endforeach; ?>







<div class="wrap backdrop">
    <div class="bg-white inner-wrapper card d-flex justify-content-center align-items-center" style="height: 118px;">

        <div class="messages" style="font-size: 20px; font-weight:bolder"></div>
        <div class="offcanvas-body d-none text-center">
            <h5 id="offcanvasBottomLabel" class="offcanvas-title">Done</h5>
            <p>
                Please review this document and click on proceed
            </p>
            <a href="<?php echo $previousPage; ?> " class="btn btn-outline-secondary waves-effect">Go
                Back</a>
            <a href="<?php echo url_for('document-edit/edit.php?document_id='.$_GET['document_id']) ?>"
                class="btn btn-primary me-1 waves-effect waves-float waves-light" id="proceed_toEdit">Proceed</a>
        </div>

    </div>
</div>

</div>

<?php include(SHARED_PATH . '/footer.php') ?>

<script type=" text/javascript" src="js/pdf.js"></script>
<!-- <script type="text/javascript" src="js/pdf.worker.js"></script> -->
<script type="text/javascript" src="js/document.loader.js"></script>
<script>
$(document).ready(function() {
    $(".messages").html("Preparing Document...")
    setTimeout(function() {
        encrypt("Encrypting...")
    }, 3000);
});

function encrypt(msg) {
    $(".messages").html(msg)
    done()
}

function done() {
    setTimeout(function() {
        $(".messages").addClass("d-none")
        $(".offcanvas-body").removeClass("d-none");
        $(".wrap").attr("class", "wrap");
    }, 3000);
}
</script>