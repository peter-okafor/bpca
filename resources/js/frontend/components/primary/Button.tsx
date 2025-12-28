import React from 'react';

interface ButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
  /**
   * Is this the principal call to action on the page?
   */
  primary?: boolean;
  /**
   * What background color to use
   */
  backgroundColor?: string;
  /**
   * What text color to use
   */
  textColor?: string;
  /**
   * Button contents
   */
  label: string;
  /**
   * Icon
   */
  icon?: JSX.Element;
  /**
   * additional class
   */
  className?: string;
  /**
   * Optional click handler
   */
  onClick?: (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void;
}

/**
 * Primary UI component for user interaction
 */
export const Button = ({
  primary = false,
  backgroundColor,
  textColor,
  label,
  icon,
  className,
  onClick,
  ...props
}: ButtonProps) => {
  const mode = primary ? 
    'bg-pest-cyprus text-white' : 
    `${backgroundColor ? backgroundColor : 'bg-white'} ${textColor ? textColor : 'text-gray-700'} border`;
  return (
    <button
      type="button"
      className={['w-full mx-auto my-auto h-10 rounded-md font-bold flex flex-row justify-center py-2', mode, className].join(' ')}
      style={{ backgroundColor, color: textColor }}
      {...props}
      onClick={onClick}
    >
      {icon}{label}
    </button>
  );
};
