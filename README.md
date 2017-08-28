# ![Islandora Collection](https://cloud.githubusercontent.com/assets/2371345/25621707/898d9de2-2f28-11e7-96e6-eb9ba218db76.png) Islandora Collection
[![Build Status](https://travis-ci.org/Islandora-CLAW/islandora_collection.png?branch=8.x-1.x)
](https://travis-ci.org/Islandora-CLAW/islandora_collection)
[![Contribution Guidelines](http://img.shields.io/badge/CONTRIBUTING-Guidelines-blue.svg)](./CONTRIBUTING.md)
[![LICENSE](https://img.shields.io/badge/license-GPLv2-blue.svg?style=flat-square)](./LICENSE)

## Introduction

Islandora Collection module for Drupal 8.2.x

## Configuration

### Members list 

This module includes a defined view which displays the objects which are a member of the viewed collection.

To enable the supplied members block to collection display follow these steps.

1. Choose **Manage** -> **Structure** -> **Block Layout**
1. On the Block Layout tab, scroll to the **Main Content** heading and press the **Place Block** button.
1. On the _Place Block_ overlay, type `member` in the _Filter by block name_ box.
1. Choose the **Members** block that appears by clicking the **Place Block** button.
1. Next a _Configure block_ window will appear.
     1. Set **Content: Member Of** from `- None -` to `Node from URL`.
     1. Under **Content Types** check `Islandora Collection`.
     1. Click **Save Block**, this closes the overlay.
1. Lastly you **must** click **Save blocks** to finish adding this block.

Now if you browse to an Islandora Collection that has a child item, you should see it displayed.

## Maintainers

Current maintainers:

* [Danny Lamb](https://github.com/dannylamb)
* [Diego Pino](https://github.com/diegopino)
* [Jared Whiklo](https://github.com/whikloj)

## Development

If you would like to contribute, please get involved by attending our weekly 
[Tech Call](https://github.com/Islandora-CLAW/CLAW/wiki). We love to hear from you!

If you would like to contribute code to the project, you need to be covered by an Islandora Foundation 
[Contributor License Agreement](http://islandora.ca/sites/default/files/islandora_cla.pdf) or 
[Corporate Contributor Licencse Agreement](http://islandora.ca/sites/default/files/islandora_ccla.pdf). Please see the 
[Contributors](http://islandora.ca/resources/contributors) pages on Islandora.ca for more information.

## License

[GPLv2](http://www.gnu.org/licenses/gpl-2.0.txt)
