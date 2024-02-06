export class CreateCopyToWishlistsListModal {
    constructor(
        config = {},
        actions = {
            performAction: () => {},
            cancelAction: () => {},
        }
    ) {
        this.config = config;
        this.defaultConfig = {
            headerTitle: 'Choose a wishlist to which selected items should be copied',
            cancelText: 'cancel',
            performText: 'perform',
            datasetWishlistTargets: '[data-bb-wishlists]',
            datasetWishlistTargetsId: '[data-bb-wishlists-id]',
            datasetWishlistCurrentId: '[data-bb-current-wishlist-id]',
            confirmationModalClass: 'copy-confirmation-modal',
            confirmationModalheaderClass: 'copy-confirmation-modal__header',
            confirmationModalH2Class: 'copy-confirmation-modal__header--title',
            confirmationModalBodyClass: 'copy-confirmation-modal__body',
            confirmationModalBodyItemClass: 'copy-confirmation-modal__body--item',
            confirmationModalConfirmClass: 'copy-confirmation-modal__confirm',
            confirmationModalCancelBtnClass: 'copy-confirmation-modal__confirm--cancel',
            confirmationModalConfirmBtnClass: 'copy-confirmation-modal__confirm--perform',
        };
        this.actions = actions;
        this.finalConfig = {...this.defaultConfig, ...config};
        this.wishlistTargets = [...document.querySelectorAll(this.finalConfig.datasetWishlistTargets)]
        this.wishlistTargetsId = [...document.querySelectorAll(this.finalConfig.datasetWishlistTargetsId)]
        this.wishlistcurrent = document.querySelector(this.finalConfig.datasetWishlistCurrentId).dataset.bbCurrentWishlistId
        this.copyTarget
    }

    init() {
        if (this.config && typeof this.config !== 'object') {
            throw new Error('BitBag - CreateCopyToWishlistsListModal - given config is not valid - expected object');
        }
        this._renderModal();
    }

    _renderModal() {
        this.modal = this._modalTemplate();
        this.modal.classList.add('bitbag', 'copy-modal-initialization');
        this._modalActions(this.modal);
        document.querySelector('body').appendChild(this.modal);
        this.modal.classList.remove('copy-modal-initialization');
        this.modal.classList.add('copy-modal-initialized');
    }

    _modalTemplate() {
        const modal = document.createElement('div');
        modal.innerHTML = `    
        <div class="modal fade ${this.finalConfig.confirmationModalClass}" tabindex="-1" role="dialog" aria-labelledby="copyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title ${this.finalConfig.confirmationModalH2Class}" id="copyModalLabel">
                            ${this.finalConfig.headerTitle}
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ${this.finalConfig.confirmationModalBodyClass}">
                        <select name="wishlist" class="form-select">
                            <option selected disabled>My Wishlist…</option>
                            ${this._getWishlists()}
                        </select>
                    </div>
                    <div class="modal-footer ${this.finalConfig.confirmationModalConfirmClass}">
                        <button type="button" class="btn btn-secondary ${this.finalConfig.confirmationModalCancelBtnClass}" data-bs-dismiss="modal">
                            ${this.finalConfig.cancelText}
                        </button>
                        <button type="button" class="btn btn-primary ${this.finalConfig.confirmationModalConfirmBtnClass}">
                            ${this.finalConfig.performText}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        `;

        return modal;
    }

    _wishlistTemplate(wishlist) {
        return `    
            <option value="${wishlist.dataset.bbWishlistsId}" data-bb-wishlist-id="${wishlist.dataset.bbWishlistsId}">
                ${wishlist.dataset.bbWishlists}
            </option>
        `;
    }

    _getWishlists() {
        let wishlistsHTML = '';
        this.wishlistTargets.forEach(wishlist => {
            wishlistsHTML += this._wishlistTemplate(wishlist);
        });
        return wishlistsHTML;
    }

    _matchWishlists(targetWishlists) {
        this.wishlistTargetsId.forEach(wishlist => {
            if (wishlist.dataset.bbWishlists == targetWishlists.value) {
                this.copyTarget = wishlist.dataset.bbWishlistsId
            }
        });
    }

    _modalActions(template) {
        const cancelBtn = template.querySelector(`.${this.finalConfig.confirmationModalCancelBtnClass}`);
        const confirmBtn = template.querySelector(`.${this.finalConfig.confirmationModalConfirmBtnClass}`);

        cancelBtn.addEventListener('click', (e) => {
            e.preventDefault();
            this.actions.cancelAction();
            this._closeModal();
        });

        confirmBtn.addEventListener('click', (e) => {
            e.preventDefault();
            this._matchWishlists(document.querySelector('[data-bb-target] select'));
            this.actions.performAction(this.wishlistcurrent, this.copyTarget);
            this._closeModal();
        });
    }

    _closeModal() {
        this.modal.remove();
    }
}

export default CreateCopyToWishlistsListModal;
