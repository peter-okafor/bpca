import React from 'react';

interface BadgeProps {
  /**
   * Badge text
   */
  text: string
}

export const Badge: React.FC<BadgeProps> = ({ text }) => {
  return (
    <div className="flex bg-green-800 text-white rounded-full w-fit px-2 items-center">
      <span className="text-xs font-light">{text}</span>
    </div>
  )
}