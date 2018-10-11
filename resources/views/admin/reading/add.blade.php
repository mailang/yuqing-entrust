<html>
<head>

    <style type="text/css">
        .modal-body table , .modal-body th, .modal-body td {border: 1px solid #d2d6de;text-align: center;height: 40px; line-height: 40px;}
    </style>
</head>
<body> <form method="POST" action="{{route('reading.store')}}">
    <input type="hidden" id="blog[id]" name="blog[blog_id]" value="{{ $read['blog_id']}}">
    <input type="hidden" id="wx[id]" name="wx[wx_id]" value="{{$read['wx_id']}}">
    <input type="hidden" id="reportform_id" name="reportform_id" value="{{$read['reportform_id']}}">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            ×
        </button>
        <h4 class="modal-title"> 微博公众号相关数据填写 </h4>
    </div>
    <div class="modal-body" style="height:400px">

        <table width="552">
            <colgroup>
                <col width="140"/>
                <col width="290"/>
                <col width="290"/>
            </colgroup>
            <tbody>
            <tr class="firstRow">
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);"></td>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    微博
                </td>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    公众号
                </td>
            </tr>
            <tr>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    关注
                </td>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    <input id="blog_concern" type="number" name="blog[concern_num]" required value="{{isset($read['blog_concern'])?$read['blog_concern']:""}}" style="height:30px;line-height: 30px;"/>
                </td>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    <input id="wx_concern" type="number" name="wx[concern_num]" value="{{isset($read['wx_concern'])?$read['wx_concern']:""}}" required style="height:30px;line-height: 30px">
                </td>
            </tr>
            <tr>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    文章
                </td>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    <input id="blog_article" type="number"  name="blog[article_num]" value="{{isset($read['blog_article'])?$read['blog_article']:""}}" required style="height:30px;line-height: 30px;"/>
                </td>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    <input id="wx_article" type="number"  name="wx[article_num]" value="{{isset($read['wx_article'])?$read['wx_article']:""}}"  required style="height:30px;line-height: 30px;"/>
                </td>
            </tr>
            <tr>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    阅读
                </td>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    <input id="blog_reading" type="number"  name="blog[reader_num]" value="{{isset($read['blog_reader'])?$read['blog_reader']:""}}" required style="height:30px;line-height: 30px;"/>
                </td>
                <td class="et3" width="84" style="font-size: 11pt; text-align: center; vertical-align: middle; border-width: 0.5pt; border-color: rgb(0, 0, 0);">
                    <input id="wx_reading" name="wx[reader_num]" type="number" value="{{isset($read['wx_reader'])?$read['wx_reader']:""}}" required style="height:30px;line-height: 30px;"/>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer" style="text-align: center">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-success btn-md">
            确认
        </button>

    </div>  </form>
</body>
</html>