
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<script src="todataurl.js"></script>
<script src="signature.js"></script>
    
</head>
<body>    

<div id="canvas">
	<canvas class="roundCorners" id="newSignature"  style="position: relative; margin: 0; padding: 0; border: 1px solid #c4caac;"></canvas>
</div>


<script>
signatureCapture();
</script>

<button type="button" onclick="signatureSave()">Save signature</button>
<button type="button" onclick="signatureClear()">Clear signature</button>
</br>
Saved Image
</br>
<img id="saveSignature" alt="Saved image png"/>

</body>
</html>
