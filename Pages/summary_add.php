<?php
include('../includes/dbcon.php');
include('../includes/header.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <style>
        .fl {
            margin-top: 2rem;
        }

        /* form label{
            width:20%;
        } */
        .common-btn {
            background-color: #62bdae;
            border: none;
            color: white !important;
        }

        .col-lg-3 {
            padding: 0px 4px;
        }

        #showdata {
            /* background-color:black; */
            /* height:70px; */
            /* margin-bottom:5px;
            border-radius:20px;
             */
        }
    </style>
</head>

<body>
    <div class="container fl">
        <div class="divCss">
            <div class="row mb-3 ">
                <div class="col">
                    <h4 class="pt-2 mb-0">Summary</h4>
                </div>
                <div class="col-auto">
                    <select class="form-select" name="cont" id="cont" required>
                        <option value="">--select--</option>
                        <option value="Shubham Manpower">Shubham Manpower</option>
                        <option value="Mahi Enterprise">Mahi Enterprise</option>
                    </select>
                </div>
                <div class="col-auto">
                    <input class="form-control" type="month" name="month" id="month">
                </div>
            </div>

            <form action="summary_db.php" method="post" autocomplete="off" id="summform" class="summform">
                <div id="showdata">
                    <br>

                </div>
            </form>
            <div class="row mb-3 mt-5">
                <div class="col-auto"> <button type="submit" class="btn  rounded-pill common-btn" name="save"
                        form="summform">Save</button></div>
                <div class="col-auto p-0"> <a type="" class="btn  rounded-pill btn-secondary "
                        href="summary.php">Back</a></div>

            </div>
        </div>
    </div>

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
                    <button type="button" class=" btn rounded-pill bg-secondary text-light"
                        data-bs-dismiss="modal">Close</button>
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
    <div class="modal fade" id="pmat" tabindex="-1" aria-labelledby="pmat" aria-hidden="true">
        <div class="modal-dialog custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Purchase </h5>
                    <button type="button" class=" btn rounded-pill common-btn completed ms-4 me-2">Completed</button>
                    <button type="button" class="btn rounded-pill common-btn add">Add</button>
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
                    <button type="button" class=" btn rounded-pill bg-secondary text-light"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn rounded-pill common-btn save" name="purchaseform"
                        id="purchaseform">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Modal -->
    <div class="modal fade" id="secondModal" tabindex="-1" aria-labelledby="secondModalLabel" aria-hidden="true">
        <div class="modal-dialog custom-modal">
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
                    <button type="button" class="btn rounded-pill common-btn" name="secondform" form="secondform"
                        id="secondform">Save</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $('#summary').addClass('active');

    $(document).on("change", "#month, #cont", function () {
        var month = $('#month').val();
        var cont = $('#cont').val();
        // console.log(month);
        if (month && cont) {
            // Check if the record already exists in the database
            $.ajax({
                url: 'summary_check_record.php', // Create a new PHP file for checking if the record exists
                type: 'post',
                data: {
                    month: month,
                    cont: cont
                },
                success: function (data) {
                    if (data === "exists") {
                        // If the record exists, redirect to the edit page for that record
                        window.location.href = 'summary_edit.php?param2=' + month + '&param1=' + cont;
                    } else {
                        // If the record doesn't exist, load the form for adding a new record
                        $.ajax({
                            url: 'summary_data.php',
                            type: 'post',
                            data: {
                                month: month,
                                cont: cont
                            },
                            success: function (data) {
                                $('#showdata').html(data);
                                // console.log(data);
                            },
                            error: function (res) {
                                console.log(res);
                            }
                        });
                    }
                },
                error: function (res) {
                    console.log(res);
                }
            });
        }
    });


    $(document).ready(function () {

        $(document).on('click', '#purchaseform', function () {
            $.ajax({
                url: 'summary_purchase_db.php',
                type: 'post',
                data: $('#purchase').serialize(),

                success: function (response) {
                    console.log(response);
                    alert("Saved Successfully");
                    $('#pmat').modal('hide');

                    var month = $('#mon').val();
                    var cont = $('#cont').val();
                    $.ajax({
                        url: 'summary_data.php',
                        type: 'post',
                        data: {
                            month: month,
                            cont: cont
                        },
                        success: function (data) {
                            $('#showdata').html(data);
                            // console.log(data);
                        },
                        error: function (res) {
                            console.log(res);
                        }
                    });


                }
            })
        });

        $(document).on('click', '#updateButton', function () {
            $.ajax({
                url: 'summary_purchasecomp1_db.php',
                type: 'post',
                data: $('#purcomplete').serialize(),
                success: function (response) {
                    alert(response);
                    $('#pmat').modal('hide');
                    console.log(response);
                    var month = $('#mon').val();
                    var cont = $('#cont').val();
                    $.ajax({
                        url: 'summary_data.php',
                        type: 'post',
                        data: {
                            month: month,
                            cont: cont
                        },
                        success: function (data) {
                            $('#showdata').html(data);
                            // console.log(data);
                        },
                        error: function (res) {
                            console.log(res);
                        }
                    });
                }
            })
        });

        $(document).on('click', '#secondform', function () {
            $.ajax({
                url: 'summary_purchasecomp_db.php',
                type: 'post',
                data: $('#addform').serialize(),
                success: function (response) {
                    console.log(response);
                    alert("saved Successfully");
                    $('#secondModal').modal('hide');
                }
            })
        });
    });
</script>

<!-- <script>
     $('#summary').addClass('active');

     $(document).on("change","#month,#cont",function(){
            var month=$('#month').val();
            var cont=$('#cont').val();
            // console.log(month);
    if(month && cont){
            $.ajax({
            url:'summary_data.php',
            type:'post',
            data:{month:month,cont:cont},
            success:function(data){
                $('#showdata').html(data);  
                // console.log(data);
            },
            error:function(res){
                    console.log(res);
                }
        });
    }
     });

</script> -->