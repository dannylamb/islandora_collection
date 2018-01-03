<?php

namespace Drupal\islandora_collection\ViewAlter;

use Drupal\Core\Entity\EntityInterface;
use Drupal\islandora\ViewAlter\ViewAlterInterface;
use Drupal\islandora\ViewAlter\LinkHeaderAlter;

/**
 * Adds a rel="collection" link header to responses.
 */
class CollectionLinkHeader extends LinkHeaderAlter implements ViewAlterInterface {

  /**
   * {@inheritdoc}
   */
  public function alter(array &$build, EntityInterface $entity) {
    // Return if memberof field does not exist.
    if ($entity->hasField('field_memberof') == FALSE) {
      return;
    }

    // Return if memberof field has no values.
    $collection_members = $entity->get('field_memberof')->getValue();
    if (count($collection_members) == 0) {
      return;
    }

    // Loop through each member and add to the collection_links.
    $collection_links = [];
    foreach ($collection_members as $member_info) {
      $collection_id = $member_info['target_id'];
      $collection_entity = $entity->load($collection_id);

      // If collection entity does not exist, skip.
      if ($collection_entity == NULL) {
        continue;
      }

      // If entity bundle type is not Collection, skip.
      $collection_entity_bundle = $collection_entity->bundle();
      if ($collection_entity_bundle != "islandora_collection") {
        continue;
      }

      $collection_entity_url = $collection_entity->url('canonical', ['absolute' => TRUE]);
      array_push($collection_links, '<' . $collection_entity_url . '>; rel="collection"');
    }

    if (count($collection_links) > 0) {
      $collection_links_str = implode(", ", $collection_links);
      $this->addLinkHeaders($build, $collection_links_str);
    }
  }

}
