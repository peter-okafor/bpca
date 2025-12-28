import React from 'react'

interface TextGroupProps {
  /**
   * label for the group
   */
  label: string
  /**
   * text to display
   */
  text: string
}

export const TextGroup: React.FC<TextGroupProps> = ({ label, text }) => {
  return (
    <div className="flex flex-col justify-center">
      <p className="text-left text-sm text-gray-400 pb-1">{label}</p>
      <p className="text-left text-sm">{text}</p>
    </div>
  )
}