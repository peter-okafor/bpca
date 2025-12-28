import React from 'react';

interface InputProps extends React.InputHTMLAttributes<HTMLInputElement> {
  /**
   * Placeholder text for the input
   */
  placeholder?: string;
}

export const Input = ({
  placeholder = "",
  ...props
}: InputProps) => {
  return (
      <input
          type="text"
          className="w-full px-4 py-2 text-sm leading-tight text-gray-700 border rounded-md appearance-none focus:outline-none border-none focus:ring-0 focus:shadow-xl h-10 disabled:bg-white disabled:opacity-90 disabled:text-black"
          placeholder={placeholder}
          {...props}
      />
  );
}