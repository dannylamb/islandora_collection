<?php

namespace Drupal\Tests\islandora_collection\Functional;

use Drupal\Tests\islandora\Functional\IslandoraFunctionalTestBase;

/**
 * Tests the CollectionLinkHeader view alter.
 *
 * @group islandora_collection
 */
class CollectionLinkHeaderTest extends IslandoraFunctionalTestBase {

  protected static $modules = ['islandora_collection'];

  protected static $configSchemaCheckerExclusions = [
    'node.type.islandora_collection',
  ];

  /**
   * Parent node that has field_memberof, but it's empty.
   *
   * @var \Drupal\node\NodeInterface
   */
  protected $parent;

  /**
   * Child node that does has field_memberof and references its parent.
   *
   * @var \Drupal\node\NodeInterface
   */
  protected $child;

  /**
   * Node of a bundle that does _not_ have field_memberof.
   *
   * @var \Drupal\node\NodeInterface
   */
  protected $other;

  /**
   * Node with two parents.
   *
   * @var \Drupal\node\NodeInterface
   */
  protected $twoParents;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create an .
    $this->other = $this->container->get('entity_type.manager')->getStorage('node')->create([
      'type' => 'test_type',
      'title' => 'Test object w/o field_memberof',
    ]);
    $this->other->save();

    // Create an object that does have field_memberof, but it's empty.
    $this->parent = $this->container->get('entity_type.manager')->getStorage('node')->create([
      'type' => 'islandora_collection',
      'title' => 'Parent Collection',
      'field_description' => 'Has children collections',
    ]);
    $this->parent->save();

    // Create an object that actually has field_memberof that points to its
    // parent.
    $this->child = $this->container->get('entity_type.manager')->getStorage('node')->create([
      'type' => 'islandora_collection',
      'title' => 'Child Collection',
      'field_description' => 'Belongs to a parent collection',
      'field_memberof' => [$this->parent->id()],
    ]);
    $this->child->save();

    // Create a node that belongs to two others.
    $this->twoParents = $this->container->get('entity_type.manager')->getStorage('node')->create([
      'type' => 'islandora_collection',
      'title' => 'Two parents',
      'field_description' => 'Has two parents',
      'field_memberof' => [$this->parent->id(), $this->other->id()],
    ]);
    $this->twoParents->save();
  }

  /**
   * @covers \Drupal\islandora_collection\ViewAlter\CollectionLinkHeader::alter
   */
  public function testCollectionLinkHeader() {
    // Create a test user.
    $account = $this->drupalCreateUser([
      'bypass node access',
    ]);
    $this->drupalLogin($account);

    // Visit the other, there should not be a header since it does not even
    // have the field.
    $this->drupalGet('node/' . $this->other->id());
    $this->assertTrue($this->doesNotHaveLinkHeader('collection'), "Node that does not have field_memberof must not return link header.");

    // Visit the parent, there should not be a header since it has the field
    // but its empty.
    $this->drupalGet('node/' . $this->parent->id());
    $this->assertTrue($this->doesNotHaveLinkHeader('collection'), "Node that has empty field_memberof must not return link header.");

    // Visit the child.  It should return one rel="collection" link header
    // pointing to the parent.
    $this->drupalGet('node/' . $this->child->id());
    $this->assertTrue(
      $this->validateLinkHeader('collection', $this->parent) == 1,
      "Malformed collection header"
    );

    // Visit the node with two parents.  It should return a rel="collection"
    // link header for each parent.
    $this->drupalGet('node/' . $this->twoParents->id());
    $this->assertTrue(
      $this->validateLinkHeader('collection', $this->parent) == 1,
      "Malformed collection header"
    );
    $this->assertTrue(
      $this->validateLinkHeader('collection', $this->parent) == 1,
      "Malformed collection header"
    );
  }

}
