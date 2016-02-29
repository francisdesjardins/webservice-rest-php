<?php
/*
 * The MIT License (MIT)
 * 
 * Copyright (c) 2014-2016 Francis Desjardins
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace FrancisDesjardins\WebService\Rest;

/**
 * Interface DataInterface
 * @package FrancisDesjardins\WebService\Rest
 */
interface DataInterface
{
    public function __construct(array $members = []);

    //! GET

    /**
     * Returns an associative array of class members
     * @return array
     */
    public function getMembers();

    //! SET

    /**
     * @param array $members
     * @return void
     */
    public function setMembers(array $members = []);

    //! PUBLIC

    /**
     * Clears the class instance of every members
     * @return void
     */
    public function clear();

    /**
     * Merges a guest 'DataInterface' instance into the host
     * @param DataInterface $guest
     * @param bool $overwrite
     * @return mixed
     */
    public function merge(DataInterface $guest, $overwrite = false);

    /**
     * Mutates the host into something else...
     * @param DataTransformerInterface $transformer
     * @return mixed
     */
    public function transform(DataTransformerInterface $transformer);

    /**
     * Returns what should be serialize for the request
     * @return mixed
     */
    public function serialize();
}