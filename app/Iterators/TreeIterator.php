<?php
namespace Iterators;

class TreeIterator extends \RecursiveDirectoryIterator
{
    private $iterator;
    private $depth;
    private $dom;
    private $version = '1.0';

    public function __construct(
        $path,
        $flags = \RecursiveDirectoryIterator::SKIP_DOTS,
        $mode = \RecursiveIteratorIterator::SELF_FIRST)
    {
        $this->dom = new \DOMDocument($this->version);
        $this->iterator = new \RecursiveIteratorIterator(
            new parent($path, $flags),
            $mode
        );
    }

    public function getHTML()
    {
        $list = $this->dom->createElement('ul');
        $list->setAttribute("class", "ul-treeFree ul-dropFree");
        $this->dom->appendChild($list);
        $node = $list;
        /** @var \SplFileInfo $fileInfo */
        foreach ($this->iterator as $fileInfo) {
            if ($this->getIteratorDepth() == $this->getDepth()) {
                $node->appendChild($this->createLiElement($fileInfo));
            } elseif ($this->getIteratorDepth() > $this->getDepth()) {
                $lastChild = $node->lastChild;
                $div = $this->dom->createElement('div');
                $div->setAttribute('class', 'drop');
                $ul = $this->dom->createElement('ul');
                $lastChild->appendChild($div);
                $lastChild->appendChild($ul);
                $ul->appendChild($this->createLiElement($fileInfo));
                $node = $ul;
            } else {
                $diff = $this->getDepth() - $this->getIteratorDepth();
                for ($i = 0; $i < $diff; $i++) {
                    $node = $node->parentNode->parentNode;
                }
                $node->appendChild($this->createLiElement($fileInfo));
            }
            $this->setDepth($this->getIteratorDepth());
        }

        return $this->dom->saveHTML();
    }

    protected function getIteratorDepth()
    {
        return $this->iterator->getDepth();
    }

    protected function createLiElement(\SplFileInfo $fileInfo)
    {
        $li = $this->dom->createElement('li');

        if ($fileInfo->isFile()) {
            $a = $this->dom->createElement('a', $fileInfo->getFilename());
            $a->setAttribute('href', '#');
            $a->setAttribute('class', 'dev-file');
            $li->appendChild($a);
        } else {
            $text = $this->dom->createTextNode($fileInfo->getFilename());
            $li->appendChild($text);
        }
        return $li;
    }

    /**
     * @param mixed $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * @return mixed
     */
    public function getDepth()
    {
        return $this->depth;
    }
}