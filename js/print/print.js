jQuery(document).ready(function($) {
    $("#cardealer-print-btn").click(function(){
        window.print();
    });
});
function Popup(data)
{
    var mywindow = window.open('', 'new div', 'height=400,width=600');
    mywindow.document.write('<html><head><title>my div</title>');
    /*optional stylesheet*/ 
    //mywindow.document.write('<link rel="stylesheet" href="../afzal.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');
    mywindow.print();
    mywindow.close();

    return true;
}