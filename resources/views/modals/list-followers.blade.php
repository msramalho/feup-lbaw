<div class="modal fade hide" id="showAllUsersModal" tabindex="-1" role="dialog" aria-labelledby="sauModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sauModalLabel">Followers List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
            </div>
            <div class="modal-body">
                @each('pages.profile.list-followers', User::getAllUserFollowers($user->id), 'user')
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>