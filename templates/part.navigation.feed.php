<li ng-class="{
        active: Navigation.isFeedActive(feed.id),
        unread: Navigation.getFeedUnreadCount(feed.id) > 0
    }"
    ng-repeat="feed in Navigation.getFeedsOfFolder(<?php p($_['folderId']); ?>) | orderBy:'id':true track by feed.url"
    ng-show="Navigation.getFeedUnreadCount(feed.id) > 0
            || Navigation.isShowAll()
            || Navigation.isFeedActive(feed.id)
            || !feed.id"
    data-id="{{ feed.id }}"
    class="feed with-counter with-menu"
    news-draggable-disable="{{ feed.error.length > 0 || !feed.id }}"
    news-draggable="{
        stack: '> li',
        zIndex: 1000,
        axis: 'y',
        delay: 200,
        containment: '#app-navigation ul',
        scroll: true,
        revert: true
    }">

    <a  ng-style="{ backgroundImage: 'url(' + feed.faviconLink + ')'}"
        ng-show="!feed.editing && !feed.deleted && !feed.error && feed.id"
        ng-href="#/items/feeds/{{ feed.id }}/"
        class="title"
        title="{{ feed.title }}">
       {{ feed.title }}
    </a>

    <a ng-hide="feed.id"
        class="entry-loading title"
        title="{{ feed.title }}">
       {{ feed.title }}
    </a>

    <div ng-if="feed.deleted" class="app-navigation-entry-deleted" news-timeout="Navigation.removeFeed(feed)">
        <div class="app-navigation-entry-deleted-description"><?php p($l->t('Deleted')); ?> {{ feed.title }}</div>
        <button class="icon-history"
                title="<?php p($l->t('Undo')); ?>"
                ng-click="Navigation.undeleteFeed(feed)"></button>
        <button class="icon-close"
                title="<?php p($l->t('Remove notification')); ?>"
                ng-click="Navigation.removeFeed(feed)"></button>
    </div>

    <div ng-if="feed.editing" class="app-navigation-entry-edit">
        <input name="feedRename" type="text" value="{{ feed.title }}" news-auto-focus>
        <button title="<?php p($l->t('Rename')); ?>"
                ng-click="Navigation.renameFeed(feed)"
                class="action icon-checkmark">
        </button>
    </div>

    <div class="app-navigation-entry-utils"
         ng-show="feed.id && !feed.editing && !feed.error && !feed.deleted">
        <ul>
            <li class="app-navigation-entry-utils-counter"
                ng-show="feed.id && Navigation.getFeedUnreadCount(feed.id) > 0">
                {{ Navigation.getFeedUnreadCount(feed.id) | unreadCountFormatter }}
            </li>
            <li class="app-navigation-entry-utils-menu-button">
                <button title="<?php p($l->t('Menu')); ?>"></button>
            </li>
        </ul>
    </div>

    <div class="app-navigation-entry-menu">
        <ul>
            <li><button ng-click="feed.editing=true"
                        class="icon-rename"
                        title="<?php p($l->t('Rename feed')); ?>"></button></li>
            <li><button ng-click="Navigation.deleteFeed(feed)"
                        class="icon-delete"
                        title="<?php p($l->t('Delete feed')); ?>"></button></li>
            <li><button ng-show="Navigation.getFeedUnreadCount(feed.id) > 0"
                        class="icon-checkmark"
                        ng-click="Navigation.markFeedRead(feed.id)"
                        title="<?php p($l->t('Read all')); ?>"></button></li>
        </ul>
    </div>

    <div class="error-message" ng-show="feed.error">
        <h2 class="title">{{ feed.url }}</h2>
        <span class="message">{{ feed.error }}</span>
        <button type="button "
                title="<?php p($l->t('Dismiss')); ?>"
                ng-click="Navigation.removeFeed(feed)"></button>
    </div>
</li>

