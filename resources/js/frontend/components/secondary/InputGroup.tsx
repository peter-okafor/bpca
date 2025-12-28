import React from 'react';

interface InputGroupProps {
  /**
   * label
   */
  label: string
  /**
   * children
   */
  children: React.ReactNode
  /**
   * class
   */
  className?: string
  /**
   * label class
   */
  labelClassName?: string
}

export const InputGroup: React.FC<InputGroupProps> = ({
  label,
  children,
  className,
  labelClassName
}) => {
  return (
    <div className={`flex flex-col ${className}`}>
      <label className={`text-sm text-white pb-1 font-semibold ${labelClassName}`}>{label}</label>
      <div className='flex flex-col'>
        {children}
      </div>
    </div>
  )
}