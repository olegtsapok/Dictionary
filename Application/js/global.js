/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function changeSettings(params)
{
    $.ajax({
       url: 'index.php?r=site/settings',
       data: params,
       success: function() { 
           location.reload(); 
       },            
   }); 
}

