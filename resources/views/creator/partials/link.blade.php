<div class="modal fade" id="add_link" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">リンクを張る</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="display_text">表示文字</div>
                <input id="display_text" name="display_text" type="text" placeholder="テキストを入力してください">
                <div class="required_alert display_text">表示文字 入力してください</div>
{{--                21.04.09 김태영--}}
{{--                미카에게 확인 --}}
{{--                type과 protocol 은 ミーグラム 에서 사용해서 그대로 디자인 했기 때문에 필요 없음--}}
{{--                url 만 사용--}}
{{--                <div class="type">リンクタイプ</div>--}}
{{--                <div class="protocol">プロコトル</div>--}}
                <div class="url">URL</div>
                <input id="url" name="url" type="text" placeholder="テキストを入力してください">
                <div class="required_alert url">url 入力してください</div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                <button id="btnLinkSave" type="button" class="btn btn-primary">設定する</button>
            </div>
        </div>
    </div>
</div>
