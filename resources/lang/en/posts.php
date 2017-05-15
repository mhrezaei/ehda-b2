<?php
return [
    'types' => [
        'meta_hint'          => 'Type meta in "key:type" format and separate theme with comma (,). If "type" isn\'t specified then it will be assumed as "text". Accepted meta:',
        'delete_alert_posts' => 'Do you even think about :count posts that belong to this category?',
        'delete_alert'       => 'It will be deleted softly, but there is no way for to recover it in the program.',
        'locales_hint'       => "Separate languages with comma (,). If you don't specify anything, only persian will be activated.",
        'order_hint'         => 'If you specify "0", it will be displayed in setting menu instead if right side menu.',
    ],

    'features' => [
        'history_system'    => "History System",
        'full_history'      => "Full History",
        'meaning'           => "Features",
        'locales'           => "Other Languages",
        'slug'              => "Set Slug",
        'download'          => "Download",
        'abstract'          => "Abstract",
        'title'             => "Title",
        'title2'            => "Second Title",
        'seo'               => "SEO",
        'long_title'        => "Long Title",
        'text'              => "Text",
        'featured_image'    => "Featured Image",
        'rss'               => "RSS",
        'price'             => "Price",
        'basket'            => "Basket",
        'comment'           => "Comment",
        'rate'              => "Rate",
        'album'             => "Album",
        'category'          => "Category",
        'cat_image'         => "Category Image",
        'searchable'        => "Searchable",
        'preview'           => "Preview",
        'digest'            => "Display in Dashboard",
        'schedule'          => "Schedule",
        'keywords'          => "Keywords",
        'register'          => "Register",
        'event'             => "Event",
        'visibility_choice' => "Visibility Choice",
        'template_choice'   => "Template Choice",
        'developers_only'   => "Developers Only",
        'feedback'          => "Feedback",
        'tags'              => 'Tags',
        'similar_things'    => 'Similar <span>::things</span>',
        'related_things'    => 'Related <span>::things</span>',
    ],

    'templates' => [
        'post'      => "Post",
        'album'     => "Alnum",
        'slideshow' => "Slide Show",
        'dialogue'  => "Dialogue",
        'faq'       => "Faq",
        'product'   => "Product",
        'special'   => "Special",
    ],

    'categories' => [
        'meaning'                  => "Categories",
        'folder'                   => "Folder",
        'folders'                  => "Folders",
        'new_folder'               => "New Folder",
        'new_category'             => "New Category",
        'folder_delete_notice'     => "Subset categories will be unfoldered.",
        'no_folder'                => "No Folder",
        'category_enabled_content' => "Categorical Content",
    ],

    'criteria' => [
        'all'       => "All",
        'published' => "Published",
        'scheduled' => "Scheduled",
        'pending'   => "Pending",
        'drafts'    => "Drafts",
        'my_posts'  => "My Posts",
        'my_drafts' => "My Drafts",
        'bin'       => "Bin",
        'approved'  => "Approved",
        'private'   => "Private",
    ],

    'visibility' => [
        'title'   => "Visibility",
        'limited' => "Limited",
        'public'  => "Public",
    ],

    'form' => [
        'copy'                                => "Copy",
        'copy_of'                             => "Copy of",
        'published_post'                      => "Published Post",
        'approved_post'                       => "Approved Post",
        'copy_status_hint'                    => "You're modifying a copy.",
        'title_placeholder'                   => "Type title here.",
        'title2_placeholder'                  => "Type second title here. (if needed)",
        'add_second_title'                    => "Add Second Title",
        'save_draft'                          => "Save Draft",
        'preview'                             => "Preview",
        'rejected'                            => "Rejected",
        'view_in_site'                        => "View in Site",
        'publish'                             => "Publish",
        'save_and_publish'                    => "Save and Publish",
        'update_button'                       => "Update",
        'send_for_approval'                   => "Send for Approval",
        'adjust_publish_time'                 => "Adjust Publish Time",
        'refer_back'                          => "Refer Back (Reject)",
        'refer_to'                            => "Refer to",
        'unpublish'                           => "Unpublish",
        'delete'                              => "Delete (Move to Bin)",
        'history'                             => "History",
        'discard_schedule'                    => "Discard Schedule",
        'is_available'                        => "Is Available",
        'is_not_available'                    => "Not Available",
        'sale_settings'                       => "Sale Settings",
        'sale_panel'                          => "Sale Panel",
        'template'                            => "Template",
        'options'                             => "Options",
        'this_page'                           => "This Page",
        'delete_alert_for_unsaved_post'       => "This text is unsaved and anything you wrote will be lost at all.",
        'delete_alert_for_copies'             => "You're modifying a copy. Are you sure you want to delete this copy?",
        'delete_alert_for_published_post'     => "This post is published and it will inaccessible for users after moving to bin.",
        'delete_this_copy'                    => "Delete This Copy",
        'unpublish_warning'                   => "Unpublishing will make this post inaccessible for users and pending.",
        'sure_unpublish'                      => "Sure Unpublish",
        'delete_original_post'                => "Delete Original Post",
        'slug'                                => "Slug",
        'valid_slug'                          => "Maybel Valid",
        'invalid_slug'                        => "Invalid Slug",
        'slug_will_be_changed_to'             => "Change it to :approved_slug.",
        'no_slug'                             => "Post with no slug hasn't any problem.",
        'discount_percent_in_parentheses'     => "(:percent% Discount)",
        'quick_edit'                          => "Quick Edit",
        'clone'                               => "Clone",
        'make_a_clone'                        => "Make a Clone",
        'make_a_clone_and_save_to_drafts'     => "Make a Clone and Save to Drafts",
        'make_a_clone_and_get_me_there'       => "Make a clone and get me there.",
        'clone_made_feedback'                 => "Clone crated and saved as draft.",
        'clone_is_a_sister'                   => "Clone is a sister.",
        'translation_already_made'            => "Translation is already made.",
        'approval'                            => "Approval",
        'deleted_post'                        => "Deleted Post",
        'automatically_change_english_digits' => "Automatically Change English Digits",
        'post_creator'                        => "Post Creator",
        'post_owner'                          => "Post Owner",
        'new_post_owner'                      => "New Post Owner",
        'change_post_owner'                   => "Change Post Owner",
        'copy_suggestion_when_cannot_publish' => "This post is approved and you can change it otherwise you make a copy.",
        'copy_suggestion_when_can_publish'    => "This post is published. It's better to make a copy to make sweeping changes.",
        'copy_suggestion_deny'                => 'Always you can to the same with "Save Draft" button.',
    ],

    'comments' => [
        'singular'               => "Comment",
        'plural'                 => "Comments",
        'users_comments'         => "Users Comments",
        'reply'                  => "Reply",
        'replies'                => "Replies",
        'dialogue'               => "Dialgue",
        'dialogue_with_number'   => "Dialogue (:number)",
        'one_of_replies'         => "One of :number Replies",
        'process'                => "Process on Comment",
        'reply_via_email_too'    => "Reply will be sent via email too.",
        'reply_or_change_status' => "Reply or Change Status",
    ],

    'album' => [
        'singular'          => "Album",
        'add_photo'         => "Add New Photo",
        'label_placeholder' => 'Photo Title (optional)',
        'link_placeholder'  => 'Photo Link (optional)',
        'remove'            => 'Remove This Photo',
    ],

    'filters' => [
        'filters'       => 'Filters',
        'no_category'   => 'No Category',
        'available'     => 'Available',
        'special_sale'  => 'Special Sale',
        'reset_filters' => 'Reset Filters',
        'range_from'    => 'from',
        'range_to'      => 'to',
    ],

];