import { FC } from "react";
import { AtoZAlphabet } from "../primary/AtoZAlphabet";

interface AtoZListProps {
    // alphabets: string[];
    className?: string;
    selectedCharacter: string;
    setSelectedCharacter: React.Dispatch<React.SetStateAction<string>>;
}

export const AtoZList: FC<AtoZListProps> = ({
    // alphabets = [],
    className,
    selectedCharacter,
    setSelectedCharacter,
}) => {
    const alphabets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

    return (
        <div className={className}>
            {alphabets.map((character, i) => (
                <AtoZAlphabet
                    key={i} 
                    selected={selectedCharacter === character}
                    onClick={() => {
                        setSelectedCharacter(character)
                    }} 
                >
                    {character}
                </AtoZAlphabet>
            ))}
        </div>
    )
}   