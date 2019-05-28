<?php


namespace PonyCool\Jwt\Validation;

use ReflectionClass;
use ReflectionException;

class ValidationStrategy extends Strategy
{
    /**
     * @return mixed
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * @param mixed $strategy
     */
    public function setStrategy(string $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * @return mixed
     */
    public function getValidationStrategy()
    {
        return $this->validationStrategy;
    }

    /**
     * @param mixed $validationStrategy
     */
    public function setValidationStrategy($validationStrategy): void
    {
        $this->validationStrategy = $validationStrategy;
    }

    /**
     * 策略验证器
     * @param string $param
     * @return bool
     * @throws ReflectionException
     */
    public function validator(string $param): bool
    {
        try {
            $strategyReflection = new ReflectionClass(__NAMESPACE__ . '\\Strategy\\' . $this->strategy);
            if (!$strategyReflection->isSubclassOf(__NAMESPACE__ . '\\Strategy\\StrategyInterface')) {
                throw new ReflectionException($this->strategy . "验证策略未实现验证策略接口");
            }
            $validationStrategy = $strategyReflection->newInstance();
            $this->setValidationStrategy($validationStrategy);
        } catch (ReflectionException $exception) {
            throw new ReflectionException($this->strategy . "验证策略加载失败");
        }
        $result = $this->getValidationStrategy()->validator($param);
        return $result;
    }
}