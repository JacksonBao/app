


// queue files to upload
function _(e) {
  return document.getElementById(e);
}


// declare accepted acceptable files
var imgArr = ['png', 'jpg', 'gif', 'jpeg'];
var vidArr = ['mp4'];
var audArr = ['mp3'];
var docs = ['txt', 'pdf', 'csv', 'docx', 'zip', 'x-zip', 'x-zip-compressed', 'octet-stream', 'vnd.ms-excel'];
var fileResponse = [];
// set cceptable extension
var c = 0;var curIndex = '';
function fhQueue(e, ex, op) {
  var files = _(e).files;
  var file = [];
  curIndex = e;
  //    Array.prototype.push.apply( file, files ); // <-- here
  // set array
  var imgExt = imgArr;
  if (ex == 'i') {
    imgExt = imgArr;
  } else if (ex == 'a') {
    imgExt = audArr;
  } else if (ex == 'v') {
    imgExt = vidArr;
  } else if (ex == 'd') {
    imgExt = docs;
  } else if (ex == 'ia') {
    imgExt = imgArr.concat(audArr);

  } else if (ex == 'iv') {
    imgExt = imgArr.concat(vidArr);
  } else if (ex == 'iav') {
    imgExt = imgArr.concat(vidArr, audArr);
  } else if (ex == 'id') {
    imgExt = imgArr.concat(docs);
  } else if (ex == '*') {
    imgExt = imgArr.concat(vidArr, audArr, docs);
  }

  if (!window.File && window.FileReader && window.FileList && window.Blob) {

    alert("Your browser does not support file upload! Please upgrade.");

    return false;

  } else {


    for (i = 0; i < files.length; i++) {
      // check file for all request data
      var f_name = files[i].name;
      var f_size = (files[i].size / 1052675.49738).toFixed(1);// files.size;
      var f_cont = files[i].type;

      var f_ext = f_cont.split('/')[1];
      var f_type = f_cont.split('/')[0];
      //            var fr = new window.FileReader();
      //            fr.onload = function (e){
      //                $().attr('src', e.target.result);
      //            }
      //
      if (f_size > 128) {
        $('#preview_' + e).prepend('<div class="w3-leftbar upErr border-warning p-2 text-warning mb-2">Could not upload the file <b>' + f_name + "</b> file size too big.</div>");
        $('.upErr').fadeOut(10000);
        //                files.splice(i, 1);
        //                 var file = files.shift(i,1);
        //                i = i - 1;
        // console.log(files);
        continue;
      } else {
        //                check extension
        if (imgExt.indexOf(f_ext) >= 0) {
          if (!$(document).hasClass(f_type + '_' + e)) {
            $('#preview_' + e).append(' <div class="d-flex flex-wrap mb-2 w-100 ' + f_type + '_' + e + '" id="' + f_type + '_' + e + '"> </div>');
          }
          var fileCnt = '<div class="p-1" id="uploadPrev_' + c + '"> <div class="border rounded " style="overflow:hidden;width:210px;"><div style="height: 150px;overflow: hidden;width:100%;" class=" bg-dark"><span id="prevDel_' + c + '" data-fileDel-status="0" onclick="v5DelFile(\'' + c + '\')" class="close p-2 w3-red" style="position:absolute;z-index:20"><i class="fa fa-trash-alt w3-tiny"></i></span><div id="prevImg_' + c + '" class="bg-dark text-light"> <div class="p-5 font-weight-bold w3-xlarge w3-text-white">' + f_ext.toUpperCase() + '</div> </div> </div><div class="w3-white p-2"><div class="text-truncate"> ' + f_name + ' </div> <small>'+f_size+'MB &nbsp; <span > <i class="fa fa-upload"></i> <span class="upTimer" id="upTimer_' + c + '"> --- </span> </span> &nbsp; <span class="upStatus" id="upStatus_' + c + '">Pending</span>  </small></div></div></div>';
          $('#' + f_type + '_' + e).append(fileCnt);

          singleUpload(files[i],  ex, op, c);
          c++;
          //                    alert();

        } else {

          $('#preview_' + e).prepend('<div class="w3-leftbar upErr border-warning p-2 text-warning mb-2"><b>' + f_name + '</b> file extension not supported.</div>');
          $('.upErr').fadeOut(10000);

          //                files.splice(i, 1);
          //                 var file = files.shift(i,1);
          //                i = i - 1;
          //                    console.log(files);

          continue;
        }

      }




    }
  }





  //    console.log(files);
}
// queue files to upload

function singleUpload(file, ex, op, i){
  //alert(file);
  // send to ajax
  var formData = new FormData();
  formData.append('upFiles', file);
  formData.append('exts', ex);
  formData.append('opt', op);
  formData.append('ind', i);

  $.ajax({

    url: '/fileHandler/upload',

    type: "POST",

    data: formData,

    contentType: false,

    cache: false,

    processData: false,

    xhr: function () {

      //upload Progress

      var xhr = $.ajaxSettings.xhr();



      if (xhr.upload) {

        xhr.upload.addEventListener("progress", function (e) {
          
          var per = 0;

          var loaded = e.loaded || e.position;

          var total = e.total;

          // $('#prev_cnt_'+srcDisp).show();

          if (e.lengthComputable) {

            per = Math.ceil((loaded / total) * 100);

          }

          var time = ck_upload_timer(per, i);

          //ck_file_loader(per, i);

          // change text

          //                    if (_('_sc_txt_' + i)) {
          //                        _('_sc_txt_' + i).innerHTML = "Remaining";
          //                    }

          //$('#per_load_'+f+'').html(per);

          $('#upTimer_' + i).html(time);
          $('#upStatus_' + i).html('<span class="fa fa-refresh"></span> Uploading..');



        }, true);

      }

      return xhr;

    },

    mimeType: "multipart/form-data"

  }).done(function (res) {

    // submit_btn.text("Add Pictures"); //disable submit button
    //$('.prevLoader').hide();

    var json = JSON.parse(res);
    if(json.Status == 200){
      var data = json.Data;
      $('#prevImg_'+json.Index).html(data);
      $('#upStatus_' + json.Index).html('<a class="w3-text-green" data-toggle="tooltip" data-placement="top" title="'+json.OrgName+'"><span class="fa fa-check-circle"></span> Success</a>');
      $('#prevDel_'+json.Index).attr('data-filedel-status', 1);
      fileResponse.push(json);
    } else { // its an error
      $('#upTimer_' + json.Index).html('');
      $('#upStatus_' + json.Index).html('<a class="w3-text-red" data-toggle="tooltip" data-placement="top" title="'+json.Data+'"><span class="fa fa-remove-circle"></span> Failed</a>');

    }
    //alert(res);

  });


}

// UPLOAD TIMER FUNCTION



// DRAG AND DROP FILES
function ck_file_drop(f, ex, op, e) {
  // e.preventDefault();
  $('#drop_txt_box').html(' ');
  var file = f;//.dataTransfer.files[0];
  console.log(file);
  cat = file.type;
  cat = cat.split('/')[0].toLowerCase();
  var nm = file.name;
  var size = (file.size / 1052675.49738).toFixed(1);
  // mame
  // alert(cat);return false;
  var imgExt = imgArr;
  if (ex == 'i') {
    imgExt = imgArr;
  } else if (ex == 'a') {
    imgExt = audArr;
  } else if (ex == 'v') {
    imgExt = vidArr;
  } else if (ex == 'd') {
    imgExt = docs;
  } else if (ex == 'ia') {
    imgExt = imgArr.concat(audArr);

  } else if (ex == 'iv') {
    imgExt = imgArr.concat(vidArr);
  } else if (ex == 'iav') {
    imgExt = imgArr.concat(vidArr, audArr);
  } else if (ex == 'id') {
    imgExt = imgArr.concat(docs);
  } else if (ex == '*') {
    imgExt = imgArr.concat(vidArr, audArr, docs);
  }


  var f_name = file.name;
  var f_size = (file.size / 1052675.49738).toFixed(1);// files.size;
  var f_cont = file.type;

  var f_ext = f_cont.split('/')[1];
  var f_type = f_cont.split('/')[0];



  if (f_size > 128) {
    $('#preview_' + e).prepend('<div class="w3-leftbar upErr border-warning p-2 text-warning mb-2">Could not upload the file <b>' + f_name + "</b> file size too big.</div>");
    $('.upErr').fadeOut(10000);
    //                files.splice(i, 1);
    //                 var file = files.shift(i,1);
    //                i = i - 1;
    //    console.log(files);
    // continue;
  } else {
    //                check extension
    if (imgExt.indexOf(f_ext) >= 0) {
      if (!$(document).hasClass(f_type + '_' + e)) {
        $('#preview_' + e).append(' <div class="d-flex flex-wrap mb-2 w-100 ' + f_type + '_' + e + '" id="' + f_type + '_' + e + '"> </div>');
      }
      var fileCnt = '<div class="p-1" id="uploadPrev_' + c + '"> <div class="border rounded " style="overflow:hidden;width:210px;"><div style="height: 150px;overflow: hidden;width:100%;" class=" bg-dark"><span id="prevDel_' + c + '" data-fileDel-status="0" onclick="v5DelFile(\'' + c + '\')" class="close p-2 w3-red" style="position:absolute;z-index:20"><i class="fa fa-trash-alt w3-tiny"></i></span><div id="prevImg_' + c + '" class="bg-dark text-light"> <div class="p-5 font-weight-bold w3-xlarge w3-text-white">' + f_ext.toUpperCase() + '</div> </div> </div><div class="w3-white p-2"><div class="text-truncate"> ' + f_name + ' </div> <small>'+f_size+'MB &nbsp; <span > <i class="fa fa-upload"></i> <span class="upTimer" id="upTimer_' + c + '"> --- </span> </span> &nbsp; <span class="upStatus" id="upStatus_' + c + '">Pending</span>  </small></div></div></div>';


      $('#' + f_type + '_' + e).append(fileCnt);

      singleUpload(file,  ex, op, c);
      c++;
      //                    alert();

    } else {

      $('#preview_' + e).prepend('<div class="w3-leftbar upErr border-warning p-2 text-warning mb-2"><b>' + f_name + '</b> file extension not supported.</div>');
      $('.upErr').fadeOut(10000);

    }

  }


  // display

}

function v5_file_drop_end(e) {
  $('#drop_txt_box').html('<div class="alert w3-center col-xs-12 alert-sm alert-warning w3-border-0 w3-leftbar w3-padding-tiny w3-border-orange w3-margin-small"><h4>Drag and Drop <b>images</b>, <b>audio</b> and <b>video</b> files </h4>   </div>');
}
function v5_file_drop_leave(e) {
  $('#drop_txt_box').html(' ');
}


// DRAG AND DROP FILES
// DECLARE TINER VARIABLES

var timer_key;

var length = 100;
var prv_tm = 0;

var timing = 0;
var time_remain = '';

var timer_array = [];



function ck_upload_timer(e, k) {

  // stat timer

  var time = new Date();

  var time_str = time.getHours() + time.getMinutes() + time.getSeconds();

  // end timer

  // time_remain = ((timing - prv_tm) * (length - e));

  // check if the item exist

  if (timer_array[k]) {

    var prev_time = timer_array[k];

    //var prev_e = timer_split[0];//previous (e)

    time_diff = time_str - prev_time;

    length_rem = length - e;

    // remaining time

    time_remain = Math.round(time_diff * length_rem);

    // do calculations

    // recreate json

    timer_array[k] = time_str;

    //console.log(time_str+"|"+prev_time+"="+time_diff+" || e ="+e+" | length = "+length_rem);

    // console.log(time_diff);

    // console.log(e);

    // console.log(length);

    // end calculation

    var timeStr = function (e) {

      if (e < 60) {

        return e + "s";

      } else if (e > 59 || e < 3600) {

        e = (e / 60).toFixed(2);

        return e + "m";

      } else if (e > 3600 || e < 216000) {

        e = (e / 60) / 60;

        var e_x = e.split('.');

        var e_f = Math.round(e);

        if (e[1]) {

          e_f += '.' + e.toFixed(2);

        }





        return e_f + "h";

      } else {

        return false;

      }

    }



    return timeStr(length_rem);



  } else {
    timer_array[k] = time_str;
    return "1s ";
  }

  // check if the item exist

}

// UPLOAD TIMER FUNCTION

function v5UploadReset(e){
  if(fileResponse.length > 0 && curIndex != e){
    //        alert(curIndex + " == " +)
    for (i=0;i < fileResponse.length; i++){
      if(fileResponse[i] != ''){
        var file = fileResponse[i].Url;
        v5DelFile(i);
      }
    }
    fileResponse = [];
  }
}

function v5DelFile(i){
  if(i >= 0){
    try {
      $.post(
        '/fileHandler/delete',
        {
          file : fileResponse[i].Url
        }, function (res){
          var js = JSON.parse(res);
          if(js.Status == 200){
            fileResponse[i] = "";
            $('#uploadPrev_'+i).html('<strong>Deleted!</strong>');
            $('#uploadPrev_'+i).fadeOut(3000);
          } else {
            // alert(js.Data)
          }
        });
      } catch(e) {
        snackBar('Error deleting file!');
      }
    }
  }
