<?php
$mounth = array
    (
    array("January", "1"),
    array("February", "2"),
    array("March", "3"),
    array("April", "4"),
    array("May", "5"),
    array("June", "6"),
    array("July", "7"),
    array("August", "8"),
    array("September", "9"),
    array("October", "10"),
    array("November", "11"),
    array("December", "12"),
);

$bulan2 = array(
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
);


$bulan = $comp['bulan'];
$tahun = $comp['tahun'];

$bln = $bulan2[$bulan - 1];
?>
<div style=" margin: 10px;" id="form_content">
    <div class="single-form">
        <form id="form_validation" method="post">
            <table>
                <tr>
                    <td valign="top" width="90%">
                        <table>
                            <tr><td><h3>The followings will check transactions before month closing : </h3></td></tr>
                            <tr>
                                <td>Please prepare a pen and a paper to write down if there is any message displayed</td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table >
                            <?php localcombobox('bulan', 'bulan1', 100, $mounth); ?>
                            <?php textbox('tahun', 'Tahun', 50, 4) ?>
                        </table>
                    </td>
                </tr>
            </table>
            <hr />
            <br />
            <table>
                <tr>

                    <td valign="top">
                        <table  width="100%">
                            <tr>
                                <td valign="top"><h3><u>Vehicle</u></h3></td>
                                <td valign="top"><h3><u>Accessories</u></h3></td>
                                <td valign="top"><h3><u>Optional</u></h3></td>
                                <td valign="top"><h3><u>BBN</u></h3></td>
                            </tr>
                            <tr>
                                <td colspan="4"> <b>* Invoice closed but not printed :</b></td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td valign="top"  width="300">
                                    <table>                                      
                                        
                                        <tr>
                                            <td>
                                               
                                                <ul class="ullist">
                                                     <li><input type="checkbox" id="veh_spk_0" name="veh_spk_0"  value="0"> SPK</li>
                                                    <li><input type="checkbox" id="veh_po_0" name="veh_po_0"  value="0"> Purchase Order</li>
                                                    <li><input type="checkbox" id="veh_prh_0" name="veh_prh_0"  value="0"> Receiving/Purchasing</li>
                                                    <li><input type="checkbox" id="veh_slh_0" name="veh_slh_0" value="0"  > Vehicle Sale</li>
                                                    <li><input type="checkbox" id="veh_rslh_0" name="veh_rslh_0"  value="0"> Sales Return</li>
                                                    <li><input type="checkbox" id="veh_rprh_0" name="veh_rprh_0"  value="0"> Purchase Return</li>
                                                    <li><input type="checkbox" id="veh_movh_0" name="veh_movh_0"  value="0"> Movement</li>
                                                    <li><br /></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                </td>
                                <td valign="top"   width="300">
                                    <table>
                                        
                                        <tr>
                                            <td>
                                                <ul class="ullist">
                                                    
                                                    <li><input type="checkbox" id="acc_poh_0" name="acc_poh_0"  value="0"> Purchase Order</li>
                                                    <li><input type="checkbox" id="acc_prh_0" name="acc_prh_0"  value="0"> Receiving/Purchasing</li>   
                                                    <li><input type="checkbox" id="acc_slh_0" name="acc_slh_0"   value="0"> Sales/Counter Sales/Usage</li>                                                                                           
                                                    <li><input type="checkbox" id="acc_opnh_0" name="acc_opnh_0"  value="0"> Opname</li>
                                                    <li><input type="checkbox" id="acc_rslh_0" name="acc_rslh_0"  value="0"> Sales Return</li>
                                                    <li><input type="checkbox" id="acc_rprh_0" name="acc_rprh_0"  value="0"> Purchase Return</li>   
                                                    <li><input type="checkbox" id="acc_movh_0" name="acc_movh_0"  value="0"> Movement</li>
                                                   
                                                </ul>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                </td>
                                <td valign="top"  width="300">
                                    <table>
                                       
                                        <tr>
                                            <td>
                                                
                                                <ul class="ullist">
                                                    <li><input type="checkbox" id="acc_worh_0" name="acc_worh_0"   value="0"> Work Order Request</li>
                                                    <li><input type="checkbox" id="acc_woh_0" name="acc_woh_0"  value="0"> Optional Work Order</li>
                                                    <li><input type="checkbox" id="acc_wprh_0" name="acc_wprh_0"  value="0"> Receiving/Purchasing</li>
                                                    <li><input type="checkbox" id="acc_wslh_0" name="acc_wslh_0"  value="0"> After-Sales</li>
                                                     <li><br /></li><li><br /></li> <li><br /></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                </td>
                                <td valign="top"  width="300">
                                    <table>
                                        
                                        <tr>
                                            <td>
                                                
                                                <ul class="ullist">
                                                    <li><input type="checkbox" id="veh_bwoh_0" name="veh_bwoh_0"   value="0"> BBN Work Order</li>
                                                    <li><input type="checkbox" id="veh_bprh_0" name="veh_bprh_0"  value="0"> BBN Registration</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">  <b>* Invoice printed more than once :</b></td>
                            </tr>
                            <tr><td></td></tr>
                            <tr>
                                <td valign="top"  width="300">
                                    <table>  
                                        <tr>
                                            <td>
                                               
                                                <ul class="ullist">
                                                     <li><input type="checkbox" id="veh_spk_1" name="veh_spk_1"  value="0"> SPK</li>
                                                    <li><input type="checkbox" id="veh_po_1" name="veh_po_1"  value="0"> Purchase Order</li>
                                                    <li><input type="checkbox" id="veh_prh_1" name="veh_prh_1"  value="0"> Receiving/Purchasing</li>
                                                    <li><input type="checkbox" id="veh_slh_1" name="veh_slh_1"  value="0" > Vehicle Sale</li>
                                                    <li><input type="checkbox" id="veh_rslh_1" name="veh_rslh_1"  value="0"> Sales Return</li>
                                                    <li><input type="checkbox" id="veh_rprh_1" name="veh_rprh_1"  value="0"> Purchase Return</li>
                                                    <li><input type="checkbox" id="veh_movh_1" name="veh_movh_1"  value="0"> Movement</li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="top"  width="300">
                                    <table>  
                                        <tr>
                                            <td>
                                                
                                                <ul class="ullist">
                                                    <li><input type="checkbox" id="acc_poh_0" name="acc_poh_0"  value="0"> Purchase Order</li>
                                                    <li><input type="checkbox" id="acc_prh_0" name="acc_prh_0"  value="0"> Receiving/Purchasing</li>  
                                                    <li><input type="checkbox" id="acc_slh_0" name="acc_slh_0"  value="0"> Sales/Counter Sales/Usage</li>                                                                                               
                                                    <li><input type="checkbox" id="acc_opnh_0" name="acc_opnh_0"  value="0"> Opname</li>
                                                    <li><input type="checkbox" id="acc_rslh_0" name="acc_rslh_0"  value="0"> Sales Return</li>
                                                    <li><input type="checkbox" id="acc_rprh_0" name="acc_rprh_0"  value="0"> Purchase Return</li>   
                                                    <li><input type="checkbox" id="acc_movh_0" name="acc_movh_0"  value="0"> Movement</li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="top"  width="300">
                                    <table>  
                                        <tr>
                                            <td>
                                                
                                                <ul class="ullist">
                                                    <li><input type="checkbox" id="acc_worh_1" name="acc_worh_1"   value="0"> Work Order Request</li>
                                                    <li><input type="checkbox" id="acc_woh_1" name="acc_woh_1"  value="0"> Optional Work Order</li>
                                                    <li><input type="checkbox" id="acc_wprh_1" name="acc_wprh_1"  value="0"> Receiving/Purchasing</li>
                                                    <li><input type="checkbox" id="acc_wslh_1" name="acc_wslh_1"  value="0"> After-Sales</li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="top"  width="300">
                                    <table>  
                                        <tr>
                                            <td>
                                                
                                                <ul class="ullist">
                                                    <li><input type="checkbox" id="veh_bwoh_1" name="veh_bwoh_1"  value="0" > BBN Work Order</li>
                                                    <li><input type="checkbox" id="veh_bprh_1" name="veh_bprh_1"  value="0"> BBN Registration</li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>


                </tr>
                <br />
                <tr><td><input type="checkbox" id="checkAll">Check All</td></tr>
                <tr>
                    <td valign="top">
                        <table>
                            <tr>
                                <td>
                                    <div id="bar"></div>
                                    <div><table><tr><td id="log"></td><td id="statTable"></td></tr></table></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </form>
    </div>

    <div class="main-nav">
        <table width="100%">
            <tr>
                <td width="400">
                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-screen'"   onclick="buttonProcess();" >Process</a>
                </td>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
            </tr>
        </table>
    </div>
</div>
<div id="dlg" class="easyui-dialog" title=" Notification" data-options="iconCls:'icon-ok',closable:true,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:900px;height:320px;padding:10px">
    <table id="tableDialog" style="height: 200px;"></table>
    <table style="margin-top:20px;" width="100%">
        <tr>
            <td align="right" colspan="2">
                <table>
                    <tr>
                        <td><button type="button" id="exit" title="<?php getCaption("export"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-export'" onclick="exportTable();" style="width:80px;">Export</button></td>
                        <td><button type="button" id="exit" title="<?php getCaption("ok"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="start();" style="width:80px;">Continue</button></td>
                        <td><button type="button" id="exit" title="<?php getCaption("exit"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="condCancel();" style="width:80px;">Quit</button></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<style>
    #tahun{text-align: right;}
    #bar {
        width:0px;
        height:25px;
        border:1px solid #ccc;
        background-color:yellow;
        border-radius:3px;
        display: none;
    }
    .ullist{
        margin-left: -30px;
        list-style-type: none;
    }
</style>
<?php include 'checking_fn.php';?>
