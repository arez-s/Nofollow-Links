<?php

/**
 * This plugin adds a "Nofollow Links" checkbox to the post editor and automatically nofollows all external links.
 *
 * @package Nofollow_Links
 */

class Nofollow_Links extends WP_Plugin {

  /**
   * Constructor.
   */
  public function __construct() {
    parent::__construct('nofollow-links');

    // Add the "Nofollow Links" checkbox to the post editor.
    add_action('edit_form_after_title', array($this, 'add_nofollow_links_checkbox'));

    // Add the "Nofollow Links" checkbox to the comment editor.
    add_action('comment_form_after_fields', array($this, 'add_nofollow_links_checkbox_to_comments'));

    // Nofollow all external links.
    add_filter('pre_link', array($this, 'nofollow_external_links'));
  }

  /**
   * Adds the "Nofollow Links" checkbox to the post editor.
   */
  public function add_nofollow_links_checkbox($post) {
    ?>
    <div class="misc-pub-section">
      <label for="nofollow_links">
        <input type="checkbox" name="nofollow_links" id="nofollow_links">
        Nofollow links
      </label>
    </div>
    <?php
  }

  /**
   * Adds the "Nofollow Links" checkbox to the comment editor.
   */
  public function add_nofollow_links_checkbox_to_comments($comment_form) {
    ?>
    <p>
      <label for="nofollow_links">
        <input type="checkbox" name="nofollow_links" id="nofollow_links">
        Nofollow links
      </label>
    </p>
    <?php
  }

  /**
   * Nofollow all external links.
   */
  public function nofollow_external_links($link) {
    if (!is_admin() && strpos($link, 'http://') === 0 || strpos($link, 'https://') === 0) {
      $link = str_replace('>', ' rel="nofollow" />', $link);
    }

    return $link;
  }
}

new Nofollow_Links();

