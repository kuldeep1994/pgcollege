<div class='admin-box'>
    <div class="tableBorder">
    <table style="margin:auto" class="mg-reciept">
        <tr style="border-bottom:1px solid #868686">
            <td><img src="http://cms.mpgc.org.in/assets/1.png"></td>
            <td>
                <h3 class="Mahila"> MAHILA P.G. COLLEGE </h3>
                <h3 class="civil">Civil Line, Bahriach (U.P)-271801 </h3>
                <h5 class="website">Website : mpgc.org.in </h5>
            </td>
        </tr>
        <tr>
            <td colspan="2"><h4 style="text-align:center;"><span class="cash">Cash Receipt</span></h4></td>
        </tr>
        <tr>
            <td><h4>Voucher No : <?php echo !empty($reciept_data->id)?$reciept_data->id:''?> </h4></td>
            <td><h4 class="Date">Date : <?php echo date('m-d-Y')?> </h4></td>
        </tr>

        <?php 
                //$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                //$value_amount = !empty($reciept_data->amount)?$reciept_data->amount:0;
        ?>

        <tr>
            <td>
                <span class="received">Received from</span>
            </td>
            <td class="tdclass">
                <b><span class="pclass classmargin"><?php echo !empty($reciept_data->student_name)?$reciept_data->student_name:''?></span></b> 
                <span class="received daughter"> D/O </span> <b><span class="pclass daughter_val"><?php echo !empty($reciept_data->father_name)?$reciept_data->father_name:''?></span></b> 
            </td>
        </tr>
        <tr>
            <td>
                 <span class="received">The sum of</span>
            </td>
            <td class="tdclass">
                <b><span class="pclass classmargin"><?php //echo $f->format($value_amount); ?></span></b>
            </td>
        </tr>
        <tr>
            <td>
                <span class="for">For</span>
            </td>
            <td class="tdclass">
                <b><span class="pclass admission">Admission form with prospectus session 2019-2020</span></b>
            </td>
        </tr>
        <tr>
           <td>
           <span class="for">Class</span>
            </td>
            <td class="forfor">
                <p class="course"><b><span class="pclass"><?php echo !empty($course)?$course:''?></span></b></p>
                    <span class="form_no for">Form no.</span>
                    <p class="course course2"><b><?php echo !empty($reciept_data->form_no)?$reciept_data->form_no:''?></b></p>
            </td>
        </tr>
        <tr>
            <td class="signature"><h4 class="Amount">Amount Rs. <?php //echo $value_amount ?> /-</h4></td>
            <td class="signature"><h4 class="Authorized">Authorized Signature </h4></td>
        </tr>
    </table><br>
    <table>
    <tr>
            <td colspan="2">
                    <input type='button' onclick='myFunction();window.location.href="http://pgcollege.com/admin/content/admission_form_sale/create"' name='print' class='btn btn-primary' value="<?php echo lang('admission_form_sale_field_print'); ?>" />
                    <?php echo anchor(SITE_AREA . '/content/admission_form_sale', lang('admission_form_sale_cancel'), 'class="btn btn-warning"'); ?>
            </td>
        </tr>
    </table>
    </div>
</div>
<style type="text/css">
.mg-reciept {
    width: 7.60in;
    background-color: transparent;
    border-collapse: collapse;
    border-spacing: 0;
    border: 2px solid;
    border-radius: 20px;
}
.mg-reciept td, .mg-reciept th {
    padding: 5px 14px 5px 28px;
    margin-left: 15px;
}
.forfor{
    padding: 5px 0px 0px 0 !important;
}
.pclass 
{
    text-align: justify;
    font-family: Arial, sans-serif;
    line-height:1.2;
    font-size: 15px;
}
.admin-box h3 
{
    color: #333;
    font-family: Arial, sans-serif;
    font-size: 11pt;
    padding: 0 10px 0 0;
    margin-left: -150px;
    font-weight: 700;
    line-height: 19px;
}  
h4 
{
    font-size: 15.5px;
    line-height: 9px;
    margin-bottom: 22px;
}
h5 
{
    font-size: 12px;
    line-height: 9px;
    margin-left: 38px;
}
.Date
{
    float: right;
}
.Authorized
{
    float: right;
}
.cash
{
    font-size: 20px;
    padding-bottom: 1px;
    border-bottom: 1px solid #868686;
}
.tdclass
{
    padding-bottom: 1px;
    border-bottom: 1px dotted;
}
span.received {
    font-style: italic;
    color: #403e3ed4;
    font-weight: 600;
    font-size: 15px;
}
span.for {
    font-style: italic;
    color: #989898;
    font-weight: 600;
    font-size: 15px;
}
*{
    font-family: Arial, sans-serif !important;
}
.classmargin
{
    margin-left: -27px;
    text-transform: capitalize;
}
.admission
{
    margin-left: -30px;
}
.form_no 
{
            margin-left: 14px;
            margin-bottom: 0px;
}
.form
{
    margin-left: 32px;
    padding-left: 38px;
    border-bottom: 1px dotted;
}
.course
{
    width: 50%;
    float: left;
    border-bottom: 1px dotted;

}
.signature
{
    position: relative;
    padding-top: 35px !important;
}
.course2
{
    float: right;
    margin-left: 18px;
    width: 140px;
}
.Mahila{
    font-size: 2.2rem !important;
    text-align: center !important;
}
.civil{
    font-size: 1.3rem !important;
    margin-top: 0.60rem !important;
    text-align: center !important;
}
.website{
    margin-left: 43px !important;
    font-size: 1rem !important;
    margin-top: 0.60rem !important;
}
.admin-box tbody {
    display: inherit;
    width: 690px;
    margin-left: 13px;
    margin-right: 0px !important;
}
@media print
{
        @page 
        {
            size: A4 portrait;
            margin:0;
        }
        .table-bordered th,
        .table-bordered td 
        {
        border: 1px solid #000 !important;
        }

        .table-bordered th,
        .table-bordered td {
        border: 1px solid #000 !important;
        }
        .signature
        {
            position: relative;
            padding-top: 35px !important;
        }
        .cash
        {
            font-size: 20px;
        }
        h5 
        {
            font-size: 13px;
            line-height: 9px;
            margin-top: 3px;
            margin-left: 0px !important;
        }
        img
        {
            width: 70px !important;
        }

        body *
        {
            visibility: hidden; 
        }
        .btn-primary
        { 
            display: none;
        }
        .btn-warning
        { 
            display: none;
        }
        .admin-box *
        { 
            visibility: visible; 
        }
        .admin-box
        {
            position: absolute; top: 40px; left: 30px;
        }

        *{
            font-family: Arial, sans-serif !important;
        }
        .admin-box h3 
        {
            color: #333;
            font-family: Arial, sans-serif;
            font-size: 11pt;
            padding: 0 10px 0 0;
            margin: 0;
            font-weight: 700;
            line-height: 19px;
        }
        .cash
        {
            margin-top: 15px;
            padding-bottom: 6px !important;
            display: inline-block;
            border-bottom: 1px solid #868686 !important;
        }
        h4 
        {
            font-size: 15.5px;
            line-height: 9px;
            margin: 2px;
            margin-bottom: 22px;
        }
        .mg-reciept 
        {
            width: 7.60in !important;
            margin-left:0.5in;
            margin-right:0.5in;
            background-color: transparent;
            border-collapse: collapse;
            border-spacing: 0;
            border: 1px solid;
            border-radius: 4px;
        }
        .mg-reciept td, .mg-reciept th {
            padding: 5px 14px 5px 14px;
            margin-left: 15px;
        }
        .pclass 
        {
            text-align: justify;
            font-family: Arial, sans-serif;
            font-size: 15px;
            color: #464444;
        }
        .Date
        {
            float: right;
        }
        .Authorized
        {
            float: right;
            margin-top:10px;
            margin-bottom: 35px;
        }
        .Amount
        {
            margin-top:10px;
            margin-bottom: 35px;
        }
        .Mahila
        {
            margin-top:10px !important;
            margin-left: -150px !important;
        }
        .civil{
            margin-left: -150px !important;
        }
        .website{
            margin-left: 43px !important;
        }
        .tdclass
        {
            padding-bottom: 1px;
            border-bottom: 1px dotted;
        }
        .classmargin
        {
            margin-left: -15px !important;
        }
        .admission
        {
            margin-left: -17px !important;
        }
        .form_no 
        {
            margin-left: 14px;
            margin-bottom: 0px;
            font-size: 12px;
            margin-top: 15px !important;
            display: inline-block;
        }

        .admin-box tbody 
        {
            display: inherit;
            width: 690px;
            margin-left: 13px;
            margin-right: 0px !important;
        }

}

</style>
<script>
function myFunction() 
{
    window.print();
}
</script>