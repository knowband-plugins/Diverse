<div class="row">
    <form id="diverseform" role="form">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading bg-white">
          LEFT SIDE<br>
          <!--<small class="text-muted">Individual form controls automatically receive some global styling. All textual &lt;input&gt;, &lt;textarea&gt;, and &lt;select&gt; elements with .form-control are set to width: 100%; by default. Wrap labels and controls in .form-group for optimum spacing.</small>-->
        </div>
        <div class="panel-body">
            <div class="form-group">
              <!--<label for="exampleInputEmail1">Email address</label>-->
              <textarea type="leftdata" class="form-control" id="editorleft" name="leftdata" ></textarea>
              <div style="color:red;font-size: 12px;" id="lefterrors"></div>
              <div style="color:orange;font-size: 12px;" id="leftwarnings"></div>
            </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      
      <div class="panel panel-default">
        <div class="panel-heading bg-white">
          RIGHT SIDE<br>
          <!--<small class="text-muted">Individual form controls automatically receive some global styling. All textual &lt;input&gt;, &lt;textarea&gt;, and &lt;select&gt; elements with .form-control are set to width: 100%; by default. Wrap labels and controls in .form-group for optimum spacing.</small>-->
        </div>
        <div class="panel-body">
            <div class="form-group">
              <!--<label for="exampleInputEmail1">Email address</label>-->
              <textarea type="rightdata" class="form-control" id="editorright" name="rightdata" ></textarea>
              <div style="color:red;font-size: 12px;" id="righterrors"></div>
              <div style="color:orange;font-size: 12px;" id="rightwarnings"></div>
            </div>
        </div>
      </div>
    </div>
    </form>
    <div id="diffdata" class="col-lg-12">
      
    </div>
  </div>
<script src="<?php echo Router::url('/'); ?>js/ace-builds/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var len = $("#editorleft").length;
    if(len){
        var editor_left = ace.edit("editorleft");
        editor_left.setTheme("ace/theme/chrome");
        editor_left.getSession().setMode("ace/mode/json");
        editor_left.setOptions({
                fontSize: "16px",
                minLines: "30",
                maxLines: "30",
                wrap: true
        });
        editor_left.$blockScrolling = Infinity;
//        editor_left.setValue('<?php // echo $leftdata; ?>');

        var textarea = $('input[name="data[TestAnswer][answer]"]');
        editor_left.getSession().on("change", function () {
            textarea.val(editor_left.getSession().getValue());
        });
    }
    var len = $("#editorright").length;
//    var edEl;
    if(len){
        var editor_right = ace.edit("editorright");
//        edEl = document.querySelector('#editorright');
        editor_right.setTheme("ace/theme/chrome");
        editor_right.getSession().setMode("ace/mode/json");
        editor_right.setOptions({
                fontSize: "16px",
                minLines: "30",
                maxLines: "30",
                wrap: true
        });
        editor_right.$blockScrolling = Infinity;
//        editor_right.setValue('<?php // echo $rightdata; ?>');
        var textarea = $('input[name="data[TestAnswer][answer]"]');
        editor_right.getSession().on("change", function () {
            textarea.val(editor_right.getSession().getValue());
            
        });
    }
    $("#compare").on("click",function(){
        
        
         editor_left.find('needle',{
            backwards: true,
            wrap: true,
            caseSensitive: true, 
            range: null,
            wholeWord: true,
            regExp: false
        });
//        editor_left.$search.set({ needle: /billing_address/  });
////
//    var found = editor_left.$search.find(editor_left.getSession());
//    console.log(found);
//    var Range = ace.require('ace/range').Range,
//    row = new Range(found.start.row, found.start.column-1, found.end.row, found.end.column); //Find Coordinates, after Line "start_#D1_SavePos"
////        
//////        var Range = ace.require('ace/range').Range // get reference to ace/range
//////editor_left.selection.moveTo(3, 5);
//editor_left.session.addMarker(
//    row, "ace_missing-line", "fullLine"
// );
//        var markerId = editor_left.renderer.addMarker(new Range(1, 10, 1, 15),
//"warning", "text");
        
        var validation_errors_left = [];
        validation_errors_left = editor_left.getSession().getAnnotations();
        
        var validation_errors_right = [];
        validation_errors_right = editor_right.getSession().getAnnotations();
//        console.log(validation_errors);
         $.ajax({
           url :"diff/prettify",
           type :"POST",
           data:{dirtydata:editor_left.getSession().getValue()},
           success:function(html){
               if(html){
                   editor_left.getSession().setValue(html);
               }
           },
           error:function(){
           }
        });
        $.ajax({
           url :"diff/prettify",
           type :"POST",
           data:{dirtydata:editor_right.getSession().getValue()},
           success:function(html){
               if(html){
                   editor_right.getSession().setValue(html);
               }
           },
           error:function(){
           }
        });
        $("#lefterrors").html("");
        $("#leftwarnings").html("");
        $("#righterrors").html("");
        $("#rightwarnings").html("");
        if(validation_errors_left.length <= 0 && validation_errors_right.length <= 0){
            $("#loader-spin").show();
            $.ajax({
               url :"",
               type :"POST",
               data:{left_data:editor_left.getSession().getValue(),right_data:editor_right.getSession().getValue(),filterarray:$("#filterarray").val()},
               success:function(html){
                   $("#loader-spin").hide();
                   $("#diffdata").html(html);
                   $('html, body').animate({
                        scrollTop: $("#diffdata").offset().top
                    }, 1000);
               },
               error:function(){
                   $("#loader-spin").hide();
               }
            });
        }else{
            for(var i = 0; i < validation_errors_left.length; i++){
                if(validation_errors_left[i].type == "error"){
                    $("#lefterrors").append(validation_errors_left[i].text + " Row:"+ validation_errors_left[i].row + " Col:" + validation_errors_left[i].column);
                    $("#lefterrors").append("<br/>");
                    console.log(validation_errors_left[i]);
                }
                if(validation_errors_left[i].type == "warning"){
                    $("#leftwarnings").append(validation_errors_left[i].text + " Row:"+ validation_errors_left[i].row + " Col:" + validation_errors_left[i].column);
                    $("#leftwarnings").append("<br/>");
                }
            }
            for(var i = 0; i < validation_errors_right.length; i++){
                if(validation_errors_right[i].type == "error"){
                    $("#righterrors").append(validation_errors_right[i].text + " Row:"+ validation_errors_right[i].row + " Col:" + validation_errors_right[i].column);
                    $("#righterrors").append("<br/>");
                    console.log(validation_errors_left[i]);
                }
                if(validation_errors_right[i].type == "warning"){
                    $("#rightwarnings").append(validation_errors_right[i].text + " Row:"+ validation_errors_right[i].row + " Col:" + validation_errors_right[i].column);
                    $("#rightwarnings").append("<br/>");
                }
            }
            $('html, body').animate({
                scrollTop: $("#lefterrors").offset().top
            }, 1000);
        }
//        $("#diverseform").submit();
    });
    var markerleft;
    $(document).on('click','#LEFTBOX .markers',function(){
        var row = $(this).attr("data");
        editor_left.scrollToLine(row, true, true, function () {});
        editor_right.scrollToLine(row, true, true, function () {});
        var Range = ace.require('ace/range').Range,
        range = new Range(row, 0, row, 15); //Find Coordinates, after Line "start_#D1_SavePos"
        if(typeof markerleft !== "undefined"){
            editor_left.getSession().removeMarker(markerleft);
        }
        if(typeof markerright !== "undefined"){
            editor_right.getSession().removeMarker(markerright);
        }
        markerleft = editor_left.session.addMarker(
            range, "ace_missing-line", "fullLine"
        );
        $('html, body').animate({
            scrollTop: $("#diverseform").offset().top
        }, 400);
                
    });
    var markerright;
    $(document).on('click','#RIGHTBOX .markers',function(){
        var row = $(this).attr("data");
        editor_right.scrollToLine(row, true, true, function () {});
        editor_left.scrollToLine(row, true, true, function () {});
        var Range = ace.require('ace/range').Range,
        range = new Range(row, 0, row, 15); //Find Coordinates, after Line "start_#D1_SavePos"
        if(typeof markerleft !== "undefined"){
            editor_left.getSession().removeMarker(markerleft);
        }
        if(typeof markerright !== "undefined"){
            editor_right.getSession().removeMarker(markerright);
        }
        markerright = editor_right.session.addMarker(
            range, "ace_missing-line", "fullLine"
        );
        $('html, body').animate({
            scrollTop: $("#diverseform").offset().top
        }, 400);
                
    });
    
    $(document).on('click','#VALUEBOX .markers',function(){
        
        var row_left = $(this).attr("data-left");
        var row_right = $(this).attr("data-right");
        
        
        editor_right.scrollToLine(row_right, true, true, function () {});
        editor_left.scrollToLine(row_left, true, true, function () {});
        
        var Range = ace.require('ace/range').Range,
        range_right = new Range(row_right, 0, row_right, 15); //Find Coordinates, after Line "start_#D1_SavePos"
        range_left = new Range(row_left, 0, row_left, 15); //Find Coordinates, after Line "start_#D1_SavePos"
        
        if(typeof markerright !== "undefined"){
            editor_right.getSession().removeMarker(markerright);
        }
        if(typeof markerleft !== "undefined"){
            editor_left.getSession().removeMarker(markerleft);
        }
        markerright = editor_right.session.addMarker(
            range_right, "ace_changevalue-line", "fullLine"
        );
        markerleft = editor_left.session.addMarker(
            range_left, "ace_changevalue-line", "fullLine"
        );
        $('html, body').animate({
            scrollTop: $("#diverseform").offset().top
        }, 400);
                
    });
    $(document).on('click','#exporttoexcel',function(){
        $("#loader-spin-excel").show();
        $.ajax({
           url :"diff/exportToExcel",
           type :"POST",
           data:{left_data:editor_left.getSession().getValue(),right_data:editor_right.getSession().getValue(),filterarray:$("#filterarray").val()},
           success:function(html){
               $("#loader-spin-excel").hide();
               $("#downloadExcel").trigger("click");
           },
           error:function(){
               $("#loader-spin-excel").hide();
           }
        });
    });
    
    
</script>