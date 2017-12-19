
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <table class="main-form">
            <tr>
                <td width="30%" valign="top">
                    <table>
                        <?php textbox('username', 'Username', 150, 70); ?>
                        <?php textbox('useralias', 'User Alias', 150, 70); ?>
                        <tr>
                            <td>User Role</td>
                            <td class="td-ro">:</td>
                            <td>
                                <select class="easyui-combobox" name="userrole" id="userrole" style="width:150px;" disabled="disabled">
                                    <option value=""></option>
                                    <option value="Sales Admin Head">Sales Admin Head</option>
                                    <option value="Sales Admin Staff">Sales Admin Staff</option>
                                    <option value="Sales Manager">Sales Manager</option>
                                    <option value="Sales Person">Sales Person</option>
                                    <option value="Sales Supervisor">Sales Supervisor</option>
                                    <option value="Super User">Super User</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="30%" valign="top">
                    <table>
                        <?php cmdWrhsAll('wrhs_axs', 'Warehouse', 150); ?>
                        <?php cmdWrhsAll('wrhs_input', 'Default Input', 150); ?>                       
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <tr>
                            <td>Current Login</td>
                            <td class="td-ro">:</td>
                            <td><span style="color:blue; " id="curr_login" name="curr_login"></span> User(s)</td>
                        </tr>
                        <tr>
                            <td>Last Login</td>
                            <td class="td-ro">:</td>
                            <td><span style="color:blue;" id="lin_dtime" name="lin_dtime"></span></td>
                        </tr>
                        <tr>
                            <td>Last Logout</td>
                            <td class="td-ro">:</td>
                            <td><span style="color:blue;" id="lout_dtime" name="lout_dtime"></span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="easyui-tabs" id="tabscoi">
            <div title="General Access" class="main-tab">
                <table style="margin-top: 10px;">
                    <tr>
                        <td width="200"></td>
                        <td width="70"><b>View</b></td>
                        <td width="70"><b>Edit</b></td>
                        <td width="70"><b>Print</b></td>
                        <td width="70"><b>Delete</b></td>
                    </tr>
                    <tr><td colspan="5"></td></tr>
                    <tr>
                        <td>Receiving Address</td>
                        <td class="text-center"><input type="checkbox" name="vw_prtradd" id="vw_prtradd"></td>
                        <td class="text-center"><input type="checkbox" name="ed_prtradd" id="ed_prtradd"></td>
                        <td class="text-center"><input type="checkbox" name="pr_prtradd" id="pr_prtradd"></td>
                        <td class="text-center"><input type="checkbox" name="dl_prtradd" id="dl_prtradd"></td>
                    </tr>
                    <tr><td colspan="5"></td></tr>
                    <tr>
                        <td>Look Up Table</td>
                        <td class="text-center"><input type="checkbox" name="vw_lkup_rl" id="vw_lkup_rl"></td>
                        <td class="text-center"><input type="checkbox" name="ed_lkup_rl" id="ed_lkup_rl"></td>
                        <td class="text-center"><input type="checkbox" name="pr_lkup_rl" id="pr_lkup_rl"></td>
                        <td class="text-center"><input type="checkbox" name="dl_lkup_rl" id="dl_lkup_rl"></td>
                    </tr>
                    <tr><td colspan="5"></td></tr>
                    <tr>
                        <td>Sales Invoice Code</td>
                        <td class="text-center"><input type="checkbox" name="vw_sinv" id="vw_sinv"></td>
                        <td class="text-center"><input type="checkbox" name="ed_sinv" id="ed_sinv"></td>
                        <td class="text-center"><input type="checkbox" name="pr_sinv" id="pr_sinv"></td>
                        <td class="text-center"><input type="checkbox" name="dl_sinv" id="dl_sinv"></td>
                    </tr>
                    <tr><td colspan="5"></td></tr>
                    <tr>
                        <td>Purchase Invoice Code</td>
                        <td class="text-center"><input type="checkbox" name="vw_pinv" id="vw_pinv"></td>
                        <td class="text-center"><input type="checkbox" name="ed_pinv" id="ed_pinv"></td>
                        <td class="text-center"><input type="checkbox" name="pr_pinv" id="pr_pinv"></td>
                        <td class="text-center"><input type="checkbox" name="dl_pinv" id="dl_pinv"></td>
                    </tr>

                </table>
            </div>

            <div title="<?php getCaption("Setting"); ?>" class="main-tab">
                <table style="margin-top: 10px;">
                    <tr>
                        <td width="200"></td>
                        <td width="70"><b>View</b></td>
                        <td width="70"><b>Edit</b></td>
                        <td width="70"><b>Print</b></td>
                        <td width="70"><b>Delete</b></td>
                    </tr>
                    <tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr>
                    <tr>
                        <td>User Access</td>
                        <td class="text-center"><input type="checkbox" name="vw_usr_axs" id="vw_usr_axs"></td>
                        <td class="text-center"><input type="checkbox" name="ed_usr_axs" id="ed_usr_axs"></td>
                        <td class="text-center"></td>
                        <td class="text-center"><input type="checkbox" name="dl_usr_axs" id="dl_usr_axs"></td>
                    </tr>
                    <tr><td colspan="5"></td></tr>
                    <tr>
                        <td>Set Transaction Form</td>
                        <td class="text-center"><input type="checkbox" name="vw_setform" id="vw_setform"></td>
                        <td class="text-center"><input type="checkbox" name="ed_setform" id="ed_setform"></td>
                        <td class="text-center"><input type="checkbox" name="pr_setform" id="pr_setform"></td>
                        <td class="text-center"><input type="checkbox" name="dl_setform" id="dl_setform"></td>
                    </tr>
                    <tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr>

                    <tr>
                        <td>System Setup</td>
                        <td class="text-center"></td>
                        <td class="text-center"><input type="checkbox" name="ut_setup" id="ut_setup" ></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr>

                    <tr>
                        <td>Invoice No./ Transaction</td>
                        <td class="text-center"></td>
                        <td class="text-center"><input type="checkbox" name="ut_settrvn" id="ut_settrvn" ></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr><td colspan="5"></td></tr>
                    <tr>
                        <td>FP No.</td>
                        <td class="text-center"><input type="checkbox" name="vw_setfpno" id="vw_setfpno" ></td>
                        <td class="text-center"><input type="checkbox" name="ed_setfpno" id="ed_setfpno" ></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>

                    <tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr>

                    <tr>
                        <td>GL Links</td>
                        <td class="text-center"><input type="checkbox" name="vw_setvgl" id="vw_setvgl"></td>
                        <td class="text-center"><input type="checkbox" name="ed_setvgl" id="ed_setvgl"></td>
                        <td class="text-center"><input type="checkbox" name="pr_setvgl" id="pr_setvgl"></td>
                        <td class="text-center"><input type="checkbox" name="dl_setvgl" id="dl_setvgl"></td>
                    </tr>
                </table>
            </div>
            <div title="Utillity" class="main-tab">
                <table style="margin-top: 10px;">
                    <tr><td class="text-center"> <input type="checkbox" name="ut_mth_cls" id="ut_mth_cls" > <a href="#" class="checklist" name="ut_mth_cls">Close Book</a></td></tr>
                    <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
                    <tr><td class="text-center"> <input type="checkbox" name="ut_backup" id="ut_backup" > <a href="#" class="checklist" name="ut_backup">BackUp</a></td></tr>
                    <tr><td class="text-center"> <input type="checkbox" name="ut_restore" id="ut_restore" > <a href="#" class="checklist" name="ut_restore">Restore</a></td></tr>
                    <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
                    <tr><td class="text-center"> <input type="checkbox" name="ut_reindex" id="ut_reindex" > <a href="#" class="checklist" name="ut_reindex">ReIndex</a></td></tr>
                    <tr><td class="text-center"><input type="checkbox" name="ut_import" id="ut_import" > <a href="#" class="checklist" name="ut_import">Program Import</a></td></tr>
                    <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
                    <tr><td class="text-center"> <input type="checkbox" name="ut_usr_log" id="ut_usr_log" > <a href="#" class="checklist" name="ut_usr_log">View Online Users</a></td></tr>
                </table>
            </div>
        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"><?php navigation_ci(); ?></td>
                    <td width="400">
                        <table class="table"  border="0">
                            <tr>
                                <!--<td><button type="button" id="pack" title="" class="easyui-linkbutton" onclick="alert('helo')" disabled="true" >Pack</button></td>-->
                                <td><button type="button" id="clone" title="" class="easyui-linkbutton" onclick="openClone();" disabled="true" >Clone</button></td>
                                <td></td><td></td>
                                <td><button type="button" id="veh" title="" class="easyui-linkbutton" onclick="openVehOne();" disabled="true" >Vehicle</button></td>
                                <td><button type="button" id="veh2" title="" class="easyui-linkbutton" onclick="openVehTwo();" disabled="true" >Vehicle 2</button></td>

                                <td><button type="button" id="acc" title="" class="easyui-linkbutton" onclick="openAccWindow();" disabled="true" >Accessories</button></td>
                                <!--<td><button type="button" id="sync" title="" class="easyui-linkbutton" onclick="" disabled="true" >Synchronize</button></td>-->
                            </tr>
                        </table>   
                    </td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
                </tr>
            </table>
        </div>
    </form>
</div>
<div id="cloneWindow" class="easyui-window" title="User Access Clone" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:450px;height: 450px;padding:10px;top:1;">
    <div style="margin:5px; padding-left:10%;padding-right:10%;">
        <form id="formClone" method="post">
            <table style="padding: 5px;background: #ddd;">
                
                <tr><td>Make a copy of User Access from the old User selected to the new User.</td></tr>
                <tr><td></td></tr>
                <tr><td>All User Access information will be copied except the password of old User.</td></tr>
            
            </table>
            <br />
            <h3>From:</h3>
            <table style="border:1px solid #ccc;padding:5px;border-radius:8px;width: 100%;">
                 <?php cmdUsr('c_username', 'Username',200); ?>  
                <tr><td class="col100"></td></tr>
            </table>
            <h3>To:</h3>
            <table style="border:1px solid #ccc;padding:5px;border-radius:8px;width: 100%;">
                <?php textbox('n_username', 'New Username', 200, 150); ?>
                <?php password('n_password', 'New Password', 200, 150);?>
                <tr><td class="col100"></td></tr>
            </table>
            
    <br /><br />
     <div class="main-nav">
         <table width="100%">
             <tr>
                 <td></td>
                 <td align="right">
                     <table>
                         <tr>
                    <td align="center"><button style="width: 80px;" type="button" id="ok" title="" data-options="iconCls:'icon-ok'" class="easyui-linkbutton" onclick="saveClone();" >Ok</button></td>
                    <td align="center"><button style="width: 80px;" type="button" id="cancel" title="" data-options="iconCls:'icon-undo'" class="easyui-linkbutton" onclick="$('#cloneWindow').window('close');">Cancel</button></td>
                </tr>
                     </table>
                 </td>
             </tr>
         </table>
     </div>
        </form>
    </div>
</div>
<div id="windowSearchUser" class="easyui-window" title="Search" data-options="closable:false,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:500px;height:auto; max-height: 550px;padding:10px;top:1;">
    <table id="tableSearchUser"></table>
    <div id="actionSearchUser"></div>
</div>
<div id="SearchOption" style="display:none;">  
    <form id="formSearch" method="post" >    
        <div style="padding:10px;">
            <span><?php getCaption("Username"); ?>:</span>
            <input id="user" name="user">
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<?php include 'vehicle.php'; ?>
<?php include 'vehicle2.php'; ?>
<?php include 'accessories.php'; ?>
<?php include 'user_access_fn.php'; ?>

