<?php

namespace Dameert\FrontendCms\Service;


use Dameert\FrontendCms\Data\RawData;
use Dameert\FrontendCms\Exception\FileNotFoundException;
use \Dameert\FrontendCms\Exception\FileNotLoadedException;
use Dameert\FrontendCms\Exception\InvalidDataException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ContentService
{
    /**
     * @var string
     */
    private $contentPath;

    /**
     * @var string
     */
    private $templatePath;

    const _IS_HTML_TWIG_REGEX_ = '/(?P<name>.*).html.twig$/';
    const _IS_JSON_REGEX_ = '/(?P<name>.*).json$/';

    /**
     * @param string $contentPath
     */
    public function setContentPath($contentPath)
    {
        $this->contentPath = $contentPath;
    }

    /**
     * @param string $templatePath
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getTemplatePath($filename)
    {
        if ($filename) {
            return $this->templatePath . DIRECTORY_SEPARATOR . $filename;
        }

        return $this->templatePath;
    }

    /**
     * Get the Json stored data for a web page
     * @return RawData
     */
    public function getJsonContent($filename)
    {
        $file = $this->getFirstContent($filename);

        if (!$file) {
            throw new FileNotLoadedException();
        }

        $jsonString = file_get_contents($file->getPathname());
        $data = new RawData(json_decode($jsonString, true));

        if (!$data->isValid()) {
            throw new InvalidDataException();
        }

        return $data;
    }

    /**
     * @param $filename
     * @return SplFileInfo
     */
    private function getFirstContent($filename)
    {
        $finder = new Finder();
        $finder->files()->in($this->contentPath)->name($filename);

        if (!$finder->count()) {
            throw new FileNotFoundException();
        }

        $iterator = $finder->getIterator();
        $iterator->rewind();

        return $iterator->current();
    }
}