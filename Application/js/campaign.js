/**
 * ChangeCampaignBranches type
 * 
 * onclick "Available to all branches/locations "
 */
function changeCampaignBranches(campaign, isAllBranchesAvailable)
{
    if (isAllBranchesAvailable) {
        $('#selected_branches').hide();
    } else {
        $('#selected_branches').show();
    }
    
    params = {'campaign':campaign, 'isAllBranchesAvailable':isAllBranchesAvailable};
    $.ajax({
       url: 'index.php?r=campaign/setBranchesType',
       data: params,
       success: function(data) { 
       },            
   }); 
}

/**
 * Open modal dialog
 * onclick "Add"
 */
function selectBranches(campaign)
{
    params = {'campaign':campaign};
    $.ajax({
       url: 'index.php?r=campaign/selectBranches',
       data: params,
       success: function(data) { 
            $('#select_branches').html(data).dialog('open');
       },            
   }); 
}

/**
 * For modal window
 * onclick "Save"
 */
function addBranches()
{
    $.ajax({
       url: 'index.php?r=campaign/addBranches',
       data: $('form[name=selected_branches]').serialize(),
       success: function(data) { 
           $("#selected_branches").html(data);
           $('#select_branches').dialog('close');
       },            
   }); 
}

/**
 * onclick "Del"
 */
function delBranches()
{
    deletedBranches = [];
            
    $(".branch_item:checked").each(function(index, item) {
        deletedBranches[index] = item.value;
        $('#branch_row'+item.value).hide();
    });
    
    if (!deletedBranches[0]) {
        return;
    }
    
    params = {'deletedBranches':deletedBranches};
    $.ajax({
       url: 'index.php?r=campaign/deleteBranches',
       data: params,
       success: function(data) { 
           
       },            
   }); 
}

/**
 * onchange "radius"
 */
function setBranchRadius(branchId, radius)
{
    params = {'branchId':branchId, 'radius':radius};
    $.ajax({
       url: 'index.php?r=campaign/setBranchRadius',
       data: params,
   }); 
}