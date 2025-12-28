import React from 'react';
import { Button } from '../primary/Button';

interface ShowMapButtonProps {
  onClick?: (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void;
  label?: string;
  className?: string;
}

export const ShowMapButton: React.FC<ShowMapButtonProps> = ({
  onClick,
  className,
  label,
  ...props
}) => {
  return (
    <Button
        backgroundColor='bg-pest-rose'
        textColor='text-white'
        onClick={onClick}
        label={label ? label : 'Show Map'}
        className={className}
        {...props} 
    />
  )
}