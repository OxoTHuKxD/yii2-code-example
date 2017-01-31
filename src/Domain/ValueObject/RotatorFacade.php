<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.01.2017
 * Time: 17:22
 */

namespace BannerService\Domain\ValueObject;


use BannerService\Domain\Exception\Exception;

class RotatorFacade
{
    const LAYOUT_HORIZONTAL = 1;
    const LAYOUT_VERTICAL = 2;

    const TEXT_POSITION_BOTTOM = 1;
    const TEXT_POSITION_TOP = 2;

    /**
     * @var int
     */
    private $layout;

    /**
     * @var boolean
     */
    private $textExist;

    /**
     * @var int
     */
    private $textPosition;

    /**
     * @var string
     */
    private $borderColor;

    /**
     * @var float
     */
    private $borderWidth;

    /**
     * @var float
     */
    private $separatorWidth;

    /**
     * @var string
     */
    private $backgroundColor;

    /**
     * @var float
     */
    private $paddingHorizontal;

    /**
     * @var float
     */
    private $paddingVertical;

    /**
     * RotatorFacade constructor.
     * @param int $layout
     * @param bool $textExist
     * @param int $textPosition
     * @param string $borderColor
     * @param float $borderWidth
     * @param float $separatorWidth
     * @param string $backgroundColor
     * @param float $paddingHorizontal
     * @param float $paddingVertical
     * @throws Exception
     */
    public function __construct($layout, $textExist, $textPosition, $borderColor, $borderWidth, $separatorWidth, $backgroundColor, $paddingHorizontal, $paddingVertical)
    {
        $this->checkLayout($layout);
        $this->checkTextPosition($textPosition);
        $this->layout = $layout;
        $this->textExist = $textExist;
        $this->textPosition = $textPosition;
        $this->borderColor = $borderColor;
        $this->borderWidth = $borderWidth;
        $this->separatorWidth = $separatorWidth;
        $this->backgroundColor = $backgroundColor;
        $this->paddingHorizontal = $paddingHorizontal;
        $this->paddingVertical = $paddingVertical;
    }

    /**
     * @return bool
     */
    public function isHorizontalLayout()
    {
        return $this->layout === self::LAYOUT_HORIZONTAL;
    }

    /**
     * @return bool
     */
    public function isVerticalLayout()
    {
        return $this->layout === self::LAYOUT_VERTICAL;
    }

    /**
     * @return boolean
     */
    public function isTextExist()
    {
        return $this->textExist;
    }

    /**
     * @return bool
     */
    public function isTextPositionBottom()
    {
        return $this->textPosition === self::TEXT_POSITION_BOTTOM;
    }

    /**
     * @return bool
     */
    public function isTextPositionTop()
    {
        return $this->textPosition === self::TEXT_POSITION_TOP;
    }

    /**
     * @return int
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @return int
     */
    public function getTextPosition()
    {
        return $this->textPosition;
    }

    /**
     * @return string
     */
    public function getBorderColor()
    {
        return $this->borderColor;
    }

    /**
     * @return float
     */
    public function getBorderWidth()
    {
        return $this->borderWidth;
    }

    /**
     * @return float
     */
    public function getSeparatorWidth()
    {
        return $this->separatorWidth;
    }

    /**
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @return float
     */
    public function getPaddingHorizontal()
    {
        return $this->paddingHorizontal;
    }

    /**
     * @return float
     */
    public function getPaddingVertical()
    {
        return $this->paddingVertical;
    }

    /**
     * @param int $layout
     * @throws Exception
     */
    public function setLayout($layout)
    {
        $this->checkLayout($layout);
        $this->layout = $layout;
    }

    /**
     * @param int $layout
     * @throws Exception
     */
    private function checkLayout($layout)
    {
        if($layout !== self::LAYOUT_VERTICAL && $layout !== self::LAYOUT_HORIZONTAL)
            throw new Exception('Некорректный вид шаблона!');
    }

    /**
     * @param boolean $textExist
     */
    public function setTextExist($textExist)
    {
        $this->textExist = $textExist;
    }

    /**
     * @param int $textPosition
     * @throws Exception
     */
    public function setTextPosition($textPosition)
    {
        $this->checkTextPosition($textPosition);
        $this->textPosition = $textPosition;
    }

    /**
     * @param int $textPosition
     * @throws Exception
     */
    private function checkTextPosition($textPosition)
    {
        if($textPosition !== self::TEXT_POSITION_BOTTOM && $textPosition !== self::TEXT_POSITION_TOP)
            throw new Exception('Некорректое положение текста!');
    }

    /**
     * @param string $borderColor
     */
    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;
    }

    /**
     * @param float $borderWidth
     */
    public function setBorderWidth($borderWidth)
    {
        $this->borderWidth = $borderWidth;
    }

    /**
     * @param float $separatorWidth
     */
    public function setSeparatorWidth($separatorWidth)
    {
        $this->separatorWidth = $separatorWidth;
    }

    /**
     * @param string $backgroundColor
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @param float $paddingHorizontal
     */
    public function setPaddingHorizontal($paddingHorizontal)
    {
        $this->paddingHorizontal = $paddingHorizontal;
    }

    /**
     * @param float $paddingVertical
     */
    public function setPaddingVertical($paddingVertical)
    {
        $this->paddingVertical = $paddingVertical;
    }
}