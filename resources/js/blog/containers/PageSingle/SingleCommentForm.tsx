import Input from "@/blog/components/Input/Input";
import { useForm } from "@inertiajs/inertia-react";
import React, { FC } from "react";
import ButtonPrimary from "../../components/Button/ButtonPrimary";
import ButtonSecondary from "../../components/Button/ButtonSecondary";
import Textarea from "../../components/Textarea/Textarea";

export interface SingleCommentFormProps {
  className?: string;
  commentId?: number;
  onClickSubmit: (id?: number) => void;
  onClickCancel: (id?: number) => void;
  textareaRef?: React.MutableRefObject<null>;
  defaultValue?: string;
  rows?: number;
  postId: number;
}

const SingleCommentForm: FC<SingleCommentFormProps> = ({
  className = "mt-5",
  commentId,
  onClickSubmit,
  onClickCancel,
  textareaRef,
  defaultValue = "",
  rows = 4,
  postId,
}) => {
  const { data, setData, put, processing, errors } = useForm({
    postId,
    email: '',
    name: '',
    content: defaultValue,
    parent_id: commentId
  })

  const submit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    
    put('/comment', {
        preserveScroll: true,
        onSuccess: () => {
            onClickCancel();
            alert('Submitted for approval');
        },
    });
  }

  return (
    <form action="#" className={`nc-SingleCommentForm ${className}`} onSubmit={submit}>
      <Textarea
        placeholder="Add to discussion"
        ref={textareaRef}
        required={true}
        defaultValue={defaultValue}
        onChange={(e) => setData(data => {
          data.content = e.currentTarget.value
          return data
        })}
        rows={rows}
      />
      {errors.content && <div className="text-red-600">{errors.content}</div>}

      <Input
        className="mt-2"
        required={true}
        onChange={(e) => setData(data => {
          data.email = e.currentTarget.value
          return data
        })}
        placeholder="Email"
      />
      {errors.email && <div className="text-red-600">{errors.email}</div>}

      <Input
        className="mt-2"
        required={true}
        onChange={(e) => setData(data => {
          data.name = e.currentTarget.value
          return data
        })}
        placeholder="Full Name"
      />
      {errors.name && <div>{errors.name}</div>}

      <div className="mt-2 space-x-3">
        <ButtonPrimary onClick={() => onClickSubmit(commentId)} type="submit">
          Submit
        </ButtonPrimary>
        <ButtonSecondary type="button" onClick={() => onClickCancel(commentId)}>
          Cancel
        </ButtonSecondary>
      </div>
    </form>
  );
};

export default SingleCommentForm;
