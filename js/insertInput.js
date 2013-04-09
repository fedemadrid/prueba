var count = 0;
function AgregarCampos(itemid, tipoinput, i){
nextinput=i+count;	
count++;
campo = '<input type="text" id="' + itemid + '_' + nextinput + '"&nbsp; name="' + itemid + '_' + nextinput + '"&nbsp; /><br>';
$('#' + itemid).append(campo);
}
