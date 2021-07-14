<div class="modal fade" id="add_link" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="titleText">{{ __('リンクを貼る') }}</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="formBox normalFormBox">
                <dl>
                    <dt>{{ __('表示文字') }}</dt>
                    <dd><input id="display_text" name="display_text" type="text" placeholder="{{ __('テキストを入力') }}"></dd>
                </dl>
                <dl>
                    <dt>{{ __('URL') }}</dt>
                    <dd><input id="url" name="url" type="text" placeholder="{{ __('https://') }}"></dd>
                </dl>
            </div>
            <ul class="btnBox modal-footer">
                <li><button id="btnLinkSave" type="button" class="btn btnCircle btnBk">{{ __('設定する') }}</button></li>
                <li><button type="button" class="btn btnCircle" data-dismiss="modal">{{ __('キャンセル') }}</button></li>
            </ul>
        </div>
    </div>
</div>
