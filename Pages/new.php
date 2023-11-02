


<?php
include('../includes/dbcon.php');

if(isset($_POST['month'])){
    $month=$_POST['month'];
    $cont=$_POST['cont'];

    $m= date('m', strtotime($month));
    $year = date('Y', strtotime($month));
?>
<div>
    <style>
         .fl{
            margin-top:2rem;
        }
          #summtable{
            table-layout: auto;
            width: 100%;

        }       
        #summtable input{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            text-align: center;
        }
        #summtable select{
            background: transparent !important;
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            text-align: center;
        }
        b{
            color:#1f9384;
        }
        .tqty{
            background-color:yellow !important;

        }
        .common-btn{
            background-color: #62bdae;
            border:none;
            color:white !important;
        }
        #summtable td{
            padding-left:0;
            padding-right:0;

        }
        .totcol{
            background-color:#d4d0cf !important;
        
        }
        .head{
            background-color:#f2f2f2; 

        }
        .abc{
            background-color:#e6e4e3 !important;
            font-weight:500;
        }
        .drums,.mat,.tname{
           cursor: pointer;
           text-decoration:none;    
           font-weight: normal; /* Remove the boldness */
           /* font-weight:1px !important; */
           color:black;
   
        }
        .roundoff{
            font-weight: normal;
        }
        .drums:hover,.mat:hover {
            color: black; /* Set the desired color for the hover state */
        }
      
        #purchase,#abc,#drum_table{
            overflow-y: scroll; 
            overflow-x:none;
            max-height: 500px; 
        }
        /* .modal-xl{
            width:2000px !important;
        } */
     
    </style>
    
    <table class="table table-bordered text-center" id="summtable">
        <tr class="head">
            <td class="text-center" colspan="5"><b> A. SHIFTING MATERIAL MONTH OF <?php echo  $month?></b> </td>  
       </tr>
       <tr class="bg-secondary text-light">
            <th>DRUMS</th>
            <th>QTY</th>
            <th></th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php
       $drums=array('A-SERIES','BL-SERIES','CL-SERIES','CR-SERIES','KRR-SERIES','ML-SERIES','VSM-SERIES');
        $drums1=array('A','BL','CL','CR','KRR','ML','VSM');
       $rate=array(40,25,25,40,40,25,25);
       for($i=0;$i<7;$i++){
        ?>
       <tr>
            <th>
                <input type="text" class="drums" id="drums[]" name="type[]" autocomplete="off" value="<?php echo $drums[$i]?>" readonly>
                <!-- <input type="hidden" class="ser" id="ser" value="<?php echo $drums1[$i] ?>"> -->
                <input type="hidden" name="mon" class="mon" id="mon" value="<?php echo $month ?>">
                <input type="hidden" name="cont" class="cont" id="cont" value="<?php echo $cont ?>">
                <input type="hidden" name="cat[]" class="cat" id="cat[]" value="Drum">
                <input type="hidden" name="remark[]" id="remark[]" class="remark">
               
            </th>
            <?php 
            $sql="SELECT sum(Drum_No) as cn FROM Dshift WHERE format(Date,'yyyy-MM')='$month' AND Drum_series='".$drums1[$i]."' "; 
            $run=sqlsrv_query($conn,$sql);
            $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);
            ?>
          
            <td><input type="number" class="aqty" id="aqty[]" name="qty[]" value="<?php echo $row['cn'] ?>" autocomplete="off" ></td>
            <td><input type="number" class="afqty" id="afqty[]" name="fqty[]" autocomplete="off" value='' readonly></td>
            <td><input type="number" class="arate" id="arate[]" name="rate[]" value="<?php echo $rate[$i]  ?>" readonly></td>
            <td><input type="number" class="aamt" id="aamt[]" name="amt[]" value="<?php echo $rate[$i]*$row['cn']  ?>"readonly></td>
       </tr>
        <?php
        }  ?>
       <tr>
            <td></td>
            <td  class="totcol"><input type="number"  id="atqty" name="atqty" class="tqty" value="0" readonly></td>
            <td></td>
            <td></td>
            <td  class="totcol"><input type="number" id="atamt"  name="atamt" class="tamt" value="0" readonly></td>
       </tr> 
       <tr class="head"> 
             <td class="text-center "  colspan="5"> <b>B. SHIFTING MATERIAL MONTH OF <?php echo $month ?></b> </td>  
        </tr>

       <tr class="bg-secondary text-light">
            <th>MATERIALS</th>
            <th>QTY</th>
            <th>FINAL QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php   
        $material=array('PVC COMPOUND 1701 TO 2205','PVC COMPOUND ( IN PLANT )','GI / ALU WIRE (Double)','GI WIRE (IN PLANT)','RM ShiftingS RAPPING'); 

        for($i=0;$i<5;$i++){ ?>
        <tr>
            <th><input type="text" class="bmat" id="bmat[]" name="type[]" autocomplete="off" value="<?php echo $material[$i]?>">
                <input type="hidden" name="cat[]" class="cat" id="cat[]" value="RM_Shifting">
                <input type="hidden" name="remark[]" id="remark[]" class="remark">
            </th>
            <td><input type="number" class="bqty" id="bqty[]" name="qty[]" autocomplete="off"></td>
            <td><input type="number" class="bfqty" id="bfqty[]" name="fqty[]" autocomplete="off"></td>
            <td><input type="number" class="brate" id="brate[]" name="rate[]" value="<?php echo $rate[$i]  ?>" readonly></td>
            <td><input type="number" class="bamt" id="bamt[]" name="amt[]" readonly></td>
        </tr>
       <?php  }
      
        for($i=0;$i<5;$i++){ ?>
        <tr>
            <th><input type="text" class="bmat" id="bmat[]" name="type[]" autocomplete="off" >
                <input type="hidden" name="cat[]" class="cat" id="cat[]" value="RM_Shifting">
                <input type="hidden" name="remark[]" id="remark[]" class="remark">
            </th>
            <td><input type="number" class="bqty" id="bqty[]" name="qty[]" autocomplete="off"></td>
            <td><input type="number" class="bfqty" id="bfqty[]" name="fqty[]" autocomplete="off"></td>     
            <td><input type="number" class="brate" id="brate[]" name="rate[]" ></td>
            <td><input type="number" class="bamt" id="bamt[]" name="amt[]" readonly></td>
        </tr>
        <?php  }
        ?>
        <tr>
            <td colspan="2"></td>
            <td  class="totcol"><input type="number"  id="btqty" name="btqty" class="tqty" value="0" readonly></td>
            <td></td>
            <td  class="totcol"><input type="number" id="btamt" name="btamt" class="tamt1" value="0" ></td>
        </tr> 
        <tr class="head">
            <td class="text-center "  colspan="5"><b>PURCHASE MATERIALS (UNLOADING) MONTH OF <?php echo $month?> .</b> </td>  
        </tr>
        <tr class="bg-secondary text-light">
            <th>MATERIALS</th>
            <th>QTY</th>
            <th>FINAL QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
       </tr>
       <?php
      $pmaterial = ['PVC COMPOUND', 'GI WIRE', 'PVC COMPOUND(Rejection Unloading)', 'Roundoff'];

      for ($i = 0; $i < 4; $i++) {
      ?>
          <tr>
              <th>
                  <?php if ($i==3) { ?>
                    <input type="text"  id="cmat[]" name="type[]" autocomplete="off" value="<?php echo $pmaterial[$i]?>" readonly>
                    <!-- <span class="roundoff" id="cmat[]" name="type[]"><?php echo $pmaterial[$i] ?></span> -->
                     
                  <?php } else { ?>
                    <input type="text" class="mat" id="cmat[]" name="type[]" autocomplete="off" value="<?php echo $pmaterial[$i]?>" readonly>
                    <!-- <a class="mat" id="cmat[]" name="type[]"><?php echo $pmaterial[$i] ?></a> -->
                  <?php } ?>
                  <input type="hidden" id="pmaterial" value="<?php echo $pmaterial[$i] ?>">
                  <input type="hidden" class="ser" id="ser" value="<?php echo $drums[$i] ?>">
                  <input type="hidden" name="cat[]" class="cat" id="cat[]" value="Purchase_Unloading">
                  <input type="hidden" name="remark[]" id="remark[]" class="remark">
              </th>
             
             
           <td>
                <input type="number" class="cqty" id="cqty<?php echo $i; ?>" name="qty[]" autocomplete="off" value='0'>
            </td>
                
              <td><input type="number" class="cfqty" id="cfqty[]" name="fqty[]" autocomplete="off"></td>
              <td><input type="number" class="crate" id="crate[]" name="rate[]" value="<?php echo $rate[$i] ?>" readonly></td>
              <td><input type="number" class="camt" id="camt[]" name="amt[]"></td>
          </tr>
      <?php
      }
      ?>
        <tr>
            <td colspan="2"></td>
            <td  class="totcol"><input type="number"  id="ctqty" name="ctqty" class="ctqty" value="0" readonly></td>
            <td></td>
    
            <td class="totcol"><input type="number" id="ctamt" name="ctamt" class="tamt2" value="0" readonly></td>
       </tr> 
       <tr>
            <td class="abc" colspan="4">TOTAL=PURCHASE+SHIFTING</td>
            <td style="background-color:#d9d9d9"><input type="number" name="total" id="total" class="total" value="0" ></td>
        </tr>
        <tr class="head"> <TH colspan="5"><b>SUMMARY MONTH OF <?php echo $month?>(JOB WORK BILL)</b></TH>
        </tr>
        <tr  class="bg-secondary text-light">
            <th colspan="2">TEAM NAME</th>
            <th colspan="2">REMARK</th>
            <th>AMOUNT</th>
        </tr>
        <?php
        $teamname=array('RAMSAWARE','NATU MAKHWANA','DILIP CHAVDA','KETAN VAGHELA','HARI RAM SUTHAR','OTHERS');
        for($i=0;$i<6;$i++){
            ?>
        <tr>
            <td colspan="2">
                <input type="text" name="type[]" id="tname[]" class="tname" autocomplete="off"  value="<?php echo $teamname[$i] ?>">
                <!-- <input type="text" class="drums" id="drums[]" name="type[]" autocomplete="off" value="<?php echo $drums[$i]?>" readonly> -->
                <input type="hidden" name="cat[]" class="cat" id="cat[]" value="Scrap">        
            </td>
            <td colspan="2"><input type="text" name="remark[]" id="remark[]" class="remark"></td>
            <td><input type="number" name="amt[]" id="tamount[]" class="tamount"></td>
        </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="2"></td>
            <td class="abc" colspan="2"> GRAND TOTAL</td>
            <td class="totcol"><input type="number" name="grandtotal" id="grandtotal" class="grandtotal">  </td>
        </tr>
          <!-- summary modal -->
          <div class="modal fade" id="summodal" tabindex="-1" aria-labelledby="summodal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header modal-xl">
                        <h5 class="modal-title">Show Series</h5> 
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">  
                        <div id="abc">

                        </div>            
                        <!-- <form action="summary_db.php" method="post" id="purchaseform" autocomplete="off" enctype="multipart/form-data">
                        <
                        </form> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class=" btn rounded-pill bg-secondary text-light" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn rounded-pill common-btn save" name="purchaseform" form="purchaseform">Save</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="summdrum" tabindex="-1" aria-labelledby="summdrum" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header modal-xl">
                        <h5 class="modal-title">Show Series</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="drum_table">

                        </div>
                        <!-- <form action="addpos_db.php" method="post" id="editForm" autocomplete="off" enctype="multipart/form-data">

                        </form> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn btn-primary" name="edit" form="editForm">Save</button> -->
                    </div>
                </div>
            </div>
        </div>
    </table>
    </div>
    
    <!-- modal -->
    <div class="modal fade" id="summdrum" tabindex="-1" aria-labelledby="summdrum" aria-hidden="true">
            <div class="modal-dialog modal-xxl">
                <div class="modal-content">
                    <div class="modal-header modal-xxl">
                        <h5 class="modal-title">Show Series</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-xxl">
                        <div id="drum_table">

                        </div>
                        <!-- <form action="addpos_db.php" method="post" id="editForm" autocomplete="off" enctype="multipart/form-data">

                        </form> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn btn-primary" name="edit" form="editForm">Save</button> -->
                    </div>
                </div>
            </div>
        </div>
          <!-- modal -->
          <div class="modal fade" id="pmat" tabindex="-1" aria-labelledby="pmat" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header modal-xl">
                        <h5 class="modal-title">Purchase </h5>
                            <button type="button" class=" btn rounded-pill common-btn completed ms-4 me-2">Completed</button> 
                            <button type="button" class="btn rounded-pill common-btn add" >Add</button>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">              
                        <!-- <form action="summary_db.php" method="post" id="purchaseform" autocomplete="off" enctype="multipart/form-data">
                   ->
                     
                        </form> -->
                          
                       <div id="bbb">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class=" btn rounded-pill bg-secondary text-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn rounded-pill common-btn save" name="purchaseform"  id="purchaseform">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Modal -->
        <div class="modal fade" id="secondModal" tabindex="-1" aria-labelledby="secondModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <!-- <form action="summary_db.php" method="post" id="secondform" autocomplete="off" enctype="multipart/form-data">
                    </form> -->
                        <div id="add">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn rounded-pill common-btn" name="secondform" form="secondform" id="secondform">Save</button>
                    </div>
                </div>
            </div>
        </div>
<?php
}
?> 
<script>


$(document).ready(function() {

    $(document).on('click','#purchaseform', function(){
        $.ajax({                                  
            url:'summary_purchase_db.php',
            type:'post',
            data:$('#purchase').serialize(),       
                                                
            success:function(response){          
            console.log(response);                                    
                                                                
                                                                    
            alert("Saved Successfully"); 
            $('#pmat').modal('hide');
            
        }
    })
    });


 
    // Add a click event for the #purchaseform element
    $(document).on('click', '#purchaseform', function() {
        $.ajax({
            url: 'summary_purchase_db.php',
            type: 'post',
            data: $('#purchase').serialize(),
            success: function(response) {
                console.log(response);

                // Parse the JSON response to extract tqty
                var data = JSON.parse(response);
                var tqty = data.tqty;

                // Update the cqty input field with the received tqty value
                var row = $('.mat').closest('tr')
                $('.cqty').val(tqty);

                alert(response);
                console.log(response);
                $('#pmat').modal('hide');
            }
        });
    });





    $(document).on('click','#secondform', function(){
        $.ajax({                                 
            url:'summary_purchasecomp_db.php',
            type:'post',
            data:$('#addform').serialize(),       
                                                    
            success:function(response){          
            console.log(response);                                    
                
            alert("saved Successfully"); 
            $('#secondModal').modal('hide');
        }
    })
    });
});
//for drum modal
$(document).on('click','.drums',function(){
    // Find the closest parent row of the clicked "drums" element
        // var row = $(this).closest('tr');
        // // Find the "ser" input within the same row
        // var ser = row.find('#ser').val();
        var ser= $(this).val();
        console.log(ser);
        var mon= $('#mon').val();
     
        $.ajax({
            url:'summary_drum_modal.php',
            type: 'post',
            data: {mon:mon,ser:ser},  
            // dataType: 'json',
            success:function(data){
              $('#drum_table').html(data);  
              $('#summdrum').modal('show');
            }
          });
        });

        
//for material modal
$(document).on('click','.mat',function(){
        // Find the closest parent row of the clicked "drums" element
        var row = $(this).closest('tr');
        // Find the "ser" input within the same row
        var pmat = row.find('#pmaterial').val();   
        var id = $(this).closest('tr').find('.cqty').attr('id');
        var mon= $('#mon').val();
        var selectedPmat = pmat;
        $.ajax({
            url:'summary_pmat_modal.php',
            type: 'post',
            data: {mon:mon,pmat:pmat,id:id},  
            // dataType: 'json',
            success:function(data)
            {
              $('#bbb').html(data);  
              $('#pmat').modal('show');
            }
          });

        $(document).on('click','.completed',function()
        {

        var mon= $('#mon').val();
        var id = $('#temp').val();
            
            $.ajax({
                url:'summary_pmatcomp_modal.php',
                type: 'post',
                data: {mon:mon,pmat:selectedPmat,id:id},  
                // dataType: 'json',
                success:function(data)
                {
                    $('#bbb').html(data);  
                //$('#pmat').modal('show');
                }
            });
            });

        $(document).on('click','.add',function(){

        var mon= $('#mon').val();
        
    
        $.ajax({
            url:'summary_pmatadd_modal.php',
            type: 'post',
            data: {mon:mon,pmat:selectedPmat},  
            // dataType: 'json',
            success:function(data){
            $('#add').html(data);  
            $('#secondModal').modal('show');
            }
        });
        });
 });
    
    // Attach a click event to the "Completed" button
    $(document).on('click', '.completed', function() {
     
    
        var saveButton = $('.modal-footer .save');
        saveButton.text("Update");
        saveButton.removeClass("save").addClass("update");
        saveButton.attr("name", "updateButton");
        saveButton.attr("id", "updateButton");
    });
    // Function to reset the button to "Save"
    function resetSaveButton() {
        var saveButton = $('.modal-footer .update');
        saveButton.text("Save");
        saveButton.removeClass("update").addClass("save");
        saveButton.attr("name", "purchaseform");
        saveButton.attr("id", "purchaseform");
    }

    // Listen for the modal hidden event
    $('#pmat').on('hidden.bs.modal', function() {
        resetSaveButton(); // Call the function to reset the button
    });

    //for moving cursor in column
    const aqtyInputs = document.querySelectorAll('.aqty','.');

    aqtyInputs.forEach((input, index) => {
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                e.preventDefault(); // Prevent default tab behavior
                const nextIndex = (index + 1) % aqtyInputs.length;
                aqtyInputs[nextIndex].focus();
            }
        });
    });
  
    //for calculating amount for A.shifting material

    // tamt,1,2
    //aqty
    //bfqty
    //cfqty
    $(document).on("change",".aqty",function(){
        var amt = 0;
        var totalSum=0;
        var rate = $(this).closest('tr').find('.arate').val();
        var qty = $(this).closest('tr').find('.aqty').val(); 
        $(this).closest('tr').find('.aamt').val(rate*qty);

        $('.aqty').each(function () {
                const value = parseFloat($(this).val());
               
                if (!isNaN(value)) {
                    totalSum += value;
                } 
            });
            $('#atqty').val(totalSum);

        $('.aamt').each(function () {
            const value= parseFloat($(this).val());
            if (!isNaN(value)) {
                amt += value;
            }
            });
           console.log(amt); 
        $(".tamt").val(amt);   
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        $(".total").val(tamt1 + tamt2 + tamt3);
    
    });
    
      // Calculate and display the total sum for AMOUNT and QTY when the page loads
      $(document).ready(function() {
        let totalSumQty = 0;
        let totalSumAmt = 0;
        
        // Calculate the total sum for AMOUNT and QTY
        $('.aqty').each(function() {
            const qty = parseFloat($(this).val());
            const rate = parseFloat($(this).closest('tr').find('.arate').val());
            
            if (!isNaN(qty) && !isNaN(rate)) {
                const amt = qty * rate;
                totalSumQty += qty;
                totalSumAmt += amt;
            }
        });

        // Display the total sum for QTY and AMOUNT
        $('#atqty').val(totalSumQty);
        //$('#atamt').val(totalSumAmt);
         // You can choose to display the total in any field you prefer.
    });


    // $(document).on("change",".bfqty,",function(){
    //     var rate = $(this).closest('tr').find('.brate').val();
       
    //     var qty = $(this).closest('tr').find('.bfqty').val(); 
    //     $(this).closest('tr').find('.bamt').val(rate*qty);
    
    // });
    $(document).on("change",".bfqty,.brate",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.brate').val();
        var qty = $(this).closest('tr').find('.bfqty').val(); 
        $(this).closest('tr').find('.bamt').val(rate*qty);

        $('.bfqty').each(function () {
                const value = parseFloat($(this).val());
             
                if (!isNaN(value)) {
                    totalSum += value;
                } 
            });
            // Display the total sum
            $('#btqty').val(totalSum);

        $('.bamt').each(function () {
            const value= parseFloat($(this).val());
            if (!isNaN(value)) {
                amt += value;
            }
            });
           console.log(amt); 
        $(".tamt1").val(amt);   
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        $(".total").val(tamt1 + tamt2 + tamt3);
    
    });

    $(document).on("change",".cfqty",function(){
        var amt = 0;
        var totalSum= 0;
        var rate = $(this).closest('tr').find('.crate').val();
        var qty = $(this).closest('tr').find('.cfqty').val(); 
        $(this).closest('tr').find('.camt').val(rate*qty);

        $('.cfqty').each(function () {
                const value = parseFloat($(this).val());
               
                if (!isNaN(value)) {
                    totalSum += value;
                 } 
            });
         
            $('#ctqty').val(totalSum);

        $('.camt').each(function () {
            const value= parseFloat($(this).val());
            if (!isNaN(value)) {
                amt += value;
            }
            });
           console.log(amt); 
        $(".tamt2").val(amt);   
        var tamt1 = parseFloat($(".tamt").val());
        var tamt2 = parseFloat($(".tamt1").val());
        var tamt3 = parseFloat($(".tamt2").val());
        $(".total").val(tamt1 + tamt2 + tamt3);
    
    });

        //  $(document).on('focusout','.aqty',function(){
           
        //     let totalSum = 0;
        //     let totalAmt = 0;
        //     $('.aqty').each(function () {
        //         const value = parseFloat($(this).val());
               
        //         if (!isNaN(value)) {
        //             totalSum += value;
        //         } 
        //     });
        //     // Display the total sum
        //     $('#atqty').val(totalSum);

        //     $('.aamt').each(function () {
        //         const value = parseFloat($(this).val());
        //         if (!isNaN(value)) {
        //             totalAmt += value;
        //         } 
        //     });
        //     // Display the total sum
        //     $('#atamt').val(totalAmt);
        //     // $('#total').val(totalAmt);
        // });

        // Calculate and display the total sum for AMOUNT and QTY when the page loads
    // $(document).ready(function() {
    //     let totalSumQty = 0;
    //     let totalSumAmt = 0;
        
    //     // Calculate the total sum for AMOUNT and QTY
    //     $('.aqty').each(function() {
    //         const qty = parseFloat($(this).val());
    //         const rate = parseFloat($(this).closest('tr').find('.arate').val());
            
    //         if (!isNaN(qty) && !isNaN(rate)) {
    //             const amt = qty * rate;
    //             totalSumQty += qty;
    //             totalSumAmt += amt;
    //         }
    //     });

    //     // Display the total sum for QTY and AMOUNT
    //     $('#atqty').val(totalSumQty);
    //     //$('#atamt').val(totalSumAmt);
    //      // You can choose to display the total in any field you prefer.
    // });

     //for calculating amount for B.shifting material
  
    // $(document).on('focusout','.bfqty',function(){
    //         let totalSum = 0;
    //         let totalAmt = 0;
    //         $('.bfqty').each(function () {
    //             const value = parseFloat($(this).val());
             
    //             if (!isNaN(value)) {
    //                 totalSum += value;
    //             } 
    //         });
    //         // Display the total sum
    //         $('#btqty').val(totalSum);

    //         $('.bamt').each(function () {
    //             const value = parseFloat($(this).val());
    //             if (!isNaN(value)) {
    //                 totalAmt += value;
    //             } 
    //         });
    //         // Display the total sum
    //         $('#btamt').val(totalAmt);
    //         // let atamt = parseFloat($('#atamt').val()) || 0;
    //         // let total= atamt+totalAmt;
    //         // console.log(total);
    //         //  $('#total').val(total);
    //     });



    //for calculating amount for P.material unloading
    //  $(document).on("change",".cfqty,.crate",function(){
    //     var rate = $(this).closest('tr').find('.crate').val();
    //     var qty = $(this).closest('tr').find('.cfqty').val(); 
    //     $(this).closest('tr').find('.camt').val(rate*qty);
    
    // });
    // $(document).on('focusout','.cfqty',function(){
    //         let totalSum = 0;
    //         let totalAmt = 0;
    //         $('.cfqty').each(function () {
    //             const value = parseFloat($(this).val());
               
    //             if (!isNaN(value)) {
    //                 totalSum += value;
    //             } 
    //         });
    //         // Display the total sum
    //         $('#ctqty').val(totalSum);

    //         $('.camt').each(function () {
    //             const value = parseFloat($(this).val());
    //             if (!isNaN(value)) {
    //                 totalAmt += value;
    //             } 
    //         });
    //         // Display the total sum
    //         $('#ctamt').val(totalAmt);
    //         // let atamt = parseFloat($('#atamt').val()) || 0;
    //         // let btamt = parseFloat($('#btamt').val()) || 0;
    //         // let total= atamt+btamt+totalAmt;
    //         // console.log(total);
    //         //  $('#total').val(total);
    //     });
       
        // $(document).on('input','.tamt',function(){
        //     console.log('abc');
        //     let totalSum = 0;
        //     $('.tamt').each(function () {
        //         const value = parseFloat($(this).val());
               
        //         if (!isNaN(value)) {
        //             totalSum += value;
        //         } 
        //     });
        //     $('#total').val(totalSum);


        // });

// for total amt in summary month of 2023-03
        $(document).on('input','.tamount',function(){
            let totalSum = 0;
            console.log(totalSum);
            $('.tamount').each(function () {
                const value = parseFloat($(this).val());
               
                if (!isNaN(value)) {
                    totalSum += value;
                } 
            });
            // Display the total sum
            $('#grandtotal').val(totalSum);

        });
 //modal for summary      
 $(document).on('click','.tname',function(){
        // Find the closest parent row of the clicked "drums" element
        var tname=$(this).val();
        var mon= $('#mon').val();
        console.log(mon);
        console.log(tname);
        
        $.ajax({
            url:'summary_tname_modal.php',
            type: 'post',
            data: {mon:mon,tname:tname},  
            // dataType: 'json',
            success:function(data){
              $('#abc').html(data);  
              $('#summodal').modal('show');
            }
          });
        });


</script>


</script>